# Release Notes - v1.1.0 (Chub Mackerel Classifier & Portfolio Refinements)

This release introduces the **Chub Mackerel Freshness Classifier** project and updates the main portfolio repository structure.

## 🚀 What's New?

### 🐟 Chub Mackerel Freshness Classifier (`/klasifikasi kesegaran ikan kembung`)
Added a web-based computer vision application designed to evaluate mackerel freshness using deep learning feature extraction and machine learning:
* **Feature Extraction**: MobileNetV3-Large pre-trained model.
* **Classification**: Support Vector Machine (SVM) classifier.
* **Interface**: Interactive Streamlit web interface with file/sample image upload and live confidence scoring.
* **Analysis**: Categorizes as *Ikan Kembung* (Chub Mackerel) or *Ikan Lain* (Other Fish), and evaluates mackerel freshness (*Segar* vs. *Tidak Segar*).

---

## 🛠️ Repository Improvements & Updates
* **Centralized LICENSE**: Added the official MIT License to the root repository.
* **Portfolio Showcase (README)**: Updated [README.md](README.md) to register the new project under active lists and showcase sections.
* **Code Structuring**: Standardized structure of scripts for preprocessing, feature extraction, model training, and web UI.

---

## 📦 Project Setup & Local Deployment

To run the newly added project:

1. Navigate to the project directory:
   ```bash
   cd "klasifikasi kesegaran ikan kembung"
   ```
2. Set up a virtual environment:
   ```bash
   python -m venv .venv
   source .venv/bin/activate  # On Windows use: .venv\Scripts\activate
   ```
3. Install dependencies:
   ```bash
   pip install -r requirements.txt
   ```
4. Extract features & train model:
   ```bash
   python training/ekstrak_fitur.py
   python training/latih_svm.py
   ```
5. Run the web interface:
   ```bash
   streamlit run app/aplikasi_streamlit.py
   ```
