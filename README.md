<div align="center">
<a href="https://akariwill.github.io/pln/">
  <img src="https://github.com/akariwill/Otaku/blob/main/assets/images/akari.jpg" alt="logo" width="180" style="border-radius: 50%;"/>
</a>
</div>

<h1 align="center">
  <a href="https://akariwill.github.io/pln/">PLN Dashboard – Electricity Load Forecasting with ANN</a>
</h1>

# 📊 PLN Dashboard – Web-based Monitoring & Prediction System

<p align="center">
 <img src="" alt="main" width="100%">
</p>

<p align="center">
This is a Laravel-based web dashboard for managing PLN (State Electricity Company) infrastructure data and forecasting electricity load using an Artificial Neural Network (ANN) model developed in Python. The system supports viewing historical data, managing substations, transformers, and feeders, and visualizing electricity load trends and predictions.
</p>


## 🧠 Overview

**PLN Dashboard** is a full-stack web system designed to help PLN engineers and administrators monitor real-time electricity data and predict load demands for the next day. The core forecasting logic is powered by a TensorFlow-based ANN, exposed via a Python Flask API, and integrated seamlessly with Laravel's backend.

---

## 🔧 Key Features

- ✅ **Laravel + MySQL** web dashboard for infrastructure management
- ✅ **Python ANN model** (TensorFlow/Scikit-Learn) for accurate MW prediction
- ✅ **Prediction endpoint API** (`/predict`) connected via Flask
- ✅ **Monthly & daily electricity load summary**
- ✅ **Line charts** for historical trends (Chart.js)
- ✅ **Dynamic dashboard with real-time updates**
- ✅ **Clean UI with Bootstrap 5**

---
## 🔌 Prediction API Endpoint

- URL: `http://localhost:5000/predict`
- Method: `POST`
- Payload Example:

```json
{
  "histori": [
    {
      "penyulang": "Penyulang 2 - Trafo 1 - GI 1",
      "amp_siang": 123,
      "teg_siang": 20.5,
      "mw_siang": 9.1,
      "amp_malam": 110,
      "teg_malam": 21.0,
      "mw_malam": 8.8
    }
  ]
}
```

## Installation  

### Clone Repo

```bash
   git clone https://github.com/akariwill/pln.git
   cd pln
```

### Install dependencies

prerequesites:
- streamlit, openai.. etc

```bash
composer install && npm install
```

### Set up the env file

```bash
cp .env.example .env
```
Edit the .env file and configure your database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pln
DB_USERNAME=root
DB_PASSWORD=
```

### Generate application key

```bash
php artisan key:generate

```

### Run migrations (and optionally seed data)

```bash
php artisan migrate --seed
```

### Start the Laravel development server

```bash
php artisan serve
```

## Running the Python API

### navigate to the Python Dir

```bash
cd python/
```

### Install Python dependencies

```bash
pip install -r requirements.txt
```


### navigate to the Python Dir
```bash
python ann_api.py
```
The Flask API will run on http://localhost:5000/predict and is used by the Laravel app to send forecasting requests.

## Directory Structure

```bash
.
├── app/                    # Laravel application logic
├── python/                 # AI model and Flask API
│   ├── ann_api.py
│   ├── models/             # Trained model files (.h5, .joblib)
│   └── requirements.txt
├── resources/views/        # Blade view templates
├── routes/web.php          # Route definitions
├── database/               # Migrations and seeders
├── public/                 # Public assets
└── README.md
```

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Contributing

Feel free to contribute to this project by submitting pull requests or opening issues in the repository.

---

That's it! You should now have a fully functional website on your system~!
