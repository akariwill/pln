from flask import Flask, request, jsonify
import joblib
import numpy as np
import traceback
import os
from tensorflow.keras.models import load_model

app = Flask(__name__)

def load_fallback_models():
    model_siang = load_model("test/model_siang.h5", compile=False)
    model_malam = load_model("test/model_malam.h5", compile=False)
    scaler_X_siang = joblib.load("test/scaler_X_siang.joblib")
    scaler_X_malam = joblib.load("test/scaler_X_malam.joblib")
    return model_siang, model_malam, scaler_X_siang, scaler_X_malam

@app.route('/predict', methods=['POST'])
def predict_manual():
    return handle_prediction(is_dashboard=False)

@app.route('/predict-dashboard', methods=['POST'])
def predict_dashboard():
    return handle_prediction(is_dashboard=True)

def handle_prediction(is_dashboard=False):
    try:
        print("Menerima request prediksi...")
        data = request.get_json(force=True)
        print("Data diterima:", data)

        histori = data.get("histori", [])
        if isinstance(histori, dict):
            histori = list(histori.values())

        if not isinstance(histori, list) or not histori:
            return jsonify({"status": "error", "message": "Histori kosong atau tidak valid."}), 400

        features = ['amp_siang', 'teg_siang', 'mw_siang', 'amp_malam', 'teg_malam', 'mw_malam']

        if not is_dashboard:
            histori = [histori[-1]]

        penyulang = histori[-1].get("penyulang", "") if not is_dashboard else data.get("penyulang", "dashboard_default")

        model_path = f"models/model_ann_{penyulang}.joblib"
        scaler_x_path = f"models/scaler_X_{penyulang}.joblib"
        scaler_y_path = f"models/scaler_y_{penyulang}.joblib"

        use_fallback = not os.path.exists(model_path)

        if use_fallback:
            print("Menggunakan fallback model.")
            model_siang, model_malam, scaler_X_siang, scaler_X_malam = load_fallback_models()
        else:
            print(f"Memuat model khusus: {model_path}")
            model = joblib.load(model_path)
            scaler_X = joblib.load(scaler_x_path)
            scaler_y = joblib.load(scaler_y_path)

        prediksi_siang = []
        prediksi_malam = []

        for item in histori:
            try:
                X_row = np.array([[float(item[f]) for f in features]])

                if use_fallback:
                    X_scaled_siang = scaler_X_siang.transform(X_row)
                    X_scaled_malam = scaler_X_malam.transform(X_row)

                    pred_siang = float(model_siang.predict(X_scaled_siang)[0][0])
                    pred_malam = float(model_malam.predict(X_scaled_malam)[0][0])
                else:
                    if X_row.shape[1] != scaler_X.n_features_in_:
                        continue

                    X_scaled = scaler_X.transform(X_row)
                    y_pred = scaler_y.inverse_transform(model.predict(X_scaled))

                    pred_siang = float(y_pred[0][0])
                    pred_malam = float(y_pred[0][1])

                prediksi_siang.append(pred_siang)
                prediksi_malam.append(pred_malam)

            except Exception as e:
                print(f"Baris dilewati karena error: {e}")
                continue

        if not prediksi_siang or not prediksi_malam:
            return jsonify({"status": "error", "message": "Gagal memprediksi data apa pun."}), 400

        avg_siang = sum(prediksi_siang) / len(prediksi_siang)
        avg_malam = sum(prediksi_malam) / len(prediksi_malam)

        return jsonify({
            "status": "ok",
            "penyulang": penyulang,
            "prediksi_mw_siang": round(avg_siang, 4),
            "prediksi_mw_malam": round(avg_malam, 4),
            "jumlah_prediksi": len(prediksi_siang),
            "via": "dashboard" if is_dashboard else "manual"
        })

    except Exception as e:
        print("TRACEBACK:")
        traceback.print_exc()
        return jsonify({"status": "error", "message": f"Gagal memproses: {str(e)}"}), 500

if __name__ == '__main__':
    app.run(debug=True, port=5000)
