from flask import Flask, request, jsonify
import joblib
import numpy as np
import traceback
import os
from tensorflow.keras.models import load_model

app = Flask(__name__)

@app.route('/predict', methods=['POST'])
def predict():
    try:
        print("Menerima request prediksi...")
        data = request.get_json(force=True)
        print("Data diterima:", data)

        histori = data.get("histori", [])
        if isinstance(histori, dict):
            histori = list(histori.values())

        if not isinstance(histori, list) or not histori:
            return jsonify({"status": "error", "message": "Histori kosong atau tidak valid."}), 400

        last = histori[-1]
        penyulang = last.get("penyulang", "")
        if not penyulang:
            return jsonify({"status": "error", "message": "Nama penyulang tidak ditemukan."}), 400

        features = ['amp_siang', 'teg_siang', 'mw_siang', 'amp_malam', 'teg_malam', 'mw_malam']
        try:
            X_last = np.array([[float(last[f]) for f in features]])
        except KeyError as e:
            return jsonify({"status": "error", "message": f"Fitur hilang: {str(e)}"}), 400

        model_path = f"models/model_ann_{penyulang}.joblib"
        scaler_x_path = f"models/scaler_X_{penyulang}.joblib"
        scaler_y_path = f"models/scaler_y_{penyulang}.joblib"

        if os.path.exists(model_path):
            print(f"Memuat model khusus: {model_path}")
            model = joblib.load(model_path)
            scaler_X = joblib.load(scaler_x_path)
            scaler_y = joblib.load(scaler_y_path)

            if X_last.shape[1] != scaler_X.n_features_in_:
                return jsonify({'error': f'Expected {scaler_X.n_features_in_} features, got {X_last.shape[1]}'}), 400

            X_scaled = scaler_X.transform(X_last)
            y_pred_scaled = model.predict(X_scaled)
            y_pred = scaler_y.inverse_transform(y_pred_scaled)

            pred_siang = float(y_pred[0][0])
            pred_malam = float(y_pred[0][1])
        else:
            print("Model penyulang tidak ditemukan. Menggunakan fallback model siang dan malam.")

            flat_input = X_last.reshape(1, -1)

            try:
                model_siang = load_model("test/model_siang.h5", compile=False)
                scaler_X_siang = joblib.load("test/scaler_X_siang.joblib")
            except Exception as e:
                print("Error fallback siang:", str(e))
                return jsonify({'error': f'Gagal load fallback siang: {str(e)}'}), 500

            try:
                model_malam = load_model("test/model_malam.h5", compile=False)
                scaler_X_malam = joblib.load("test/scaler_X_malam.joblib")
            except Exception as e:
                print("Error fallback malam:", str(e))
                return jsonify({'error': f'Gagal load fallback malam: {str(e)}'}), 500

            if flat_input.shape[1] != scaler_X_siang.n_features_in_:
                return jsonify({'error': f'Expected {scaler_X_siang.n_features_in_} features, got {flat_input.shape[1]}'}), 400

            X_scaled_siang = scaler_X_siang.transform(flat_input)
            pred_siang = float(model_siang.predict(X_scaled_siang)[0][0])

            X_scaled_malam = scaler_X_malam.transform(flat_input)
            pred_malam = float(model_malam.predict(X_scaled_malam)[0][0])

        result = {
            "status": "ok",
            "penyulang": penyulang,
            "prediksi_mw_siang": round(pred_siang, 4),
            "prediksi_mw_malam": round(pred_malam, 4)
        }
        return jsonify(result)

    except Exception as e:
        print("TRACEBACK:")
        traceback.print_exc()
        return jsonify({"status": "error", "message": f"Gagal memproses: {str(e)}"}), 500

if __name__ == '__main__':
    app.run(debug=True, port=5000)
