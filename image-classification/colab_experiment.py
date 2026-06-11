"""
Eksperimen Klasifikasi Citra (Computer Vision)
Google Colab Compatible Script

Script ini memuat:
1. Custom CNN (VGG-style & ResNet-style)
2. Custom Vision Transformer (ViT) sederhana dengan Keras
3. Pretrained Models dengan Transfer Learning (VGG16, ResNet50, ViT via KerasHub)
4. Evaluasi (Plot Accuracy/Loss, Classification Report, Confusion Matrix)

Cara Penggunaan di Google Colab:
- Salin keseluruhan script ini ke sel Google Colab, atau jalankan tiap block yang dipisah oleh # %%
- Pastikan folder dataset ('train' dan 'val') sudah ada di environment Colab
- Install dependensi: !pip install keras-hub
"""

# %% 1. Setup dan Imports
import os
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.metrics import classification_report, confusion_matrix

import tensorflow as tf
from tensorflow.keras import layers, models
from tensorflow.keras.applications import VGG16, ResNet50

# Buat folder untuk menyimpan hasil
os.makedirs('results', exist_ok=True)

# Konfigurasi Dataset
IMG_HEIGHT, IMG_WIDTH = 128, 128
BATCH_SIZE = 32
NUM_CLASSES = 10 # Ganti jika jumlah kelas berbeda
EPOCHS = 30

print(f"TensorFlow Version: {tf.__version__}")

# %% 2. Data Loading (Menggunakan tf.keras.utils.image_dataset_from_directory yang modern)
print("Memuat dataset...")

# Dataset Training
train_dataset = tf.keras.utils.image_dataset_from_directory(
    'train',
    image_size=(IMG_HEIGHT, IMG_WIDTH),
    batch_size=BATCH_SIZE,
    label_mode='categorical',
    shuffle=True
)

# Dataset Validasi (Shuffle=False untuk Evaluasi yang konsisten)
val_dataset = tf.keras.utils.image_dataset_from_directory(
    'val',
    image_size=(IMG_HEIGHT, IMG_WIDTH),
    batch_size=BATCH_SIZE,
    label_mode='categorical',
    shuffle=False
)

class_names = train_dataset.class_names
print(f"Classes: {class_names}")

# Optimize dataset for performance
AUTOTUNE = tf.data.AUTOTUNE
train_dataset = train_dataset.cache().prefetch(buffer_size=AUTOTUNE)
val_dataset = val_dataset.cache().prefetch(buffer_size=AUTOTUNE)

# Layer Augmentasi Data (Dimasukkan ke dalam model)
data_augmentation = tf.keras.Sequential([
    layers.RandomFlip("horizontal"),
    layers.RandomRotation(0.2),
    layers.RandomZoom(0.2),
], name="data_augmentation")

# %% 3. Arsitektur Custom CNN (VGG-Style)
def build_custom_vgg(input_shape=(IMG_HEIGHT, IMG_WIDTH, 3), num_classes=NUM_CLASSES):
    """Membangun arsitektur Custom CNN yang lebih dalam terinspirasi dari VGG."""
    inputs = layers.Input(shape=input_shape)
    x = data_augmentation(inputs)
    x = layers.Rescaling(1./255)(x)
    
    # Block 1
    x = layers.Conv2D(32, (3, 3), padding='same', activation='relu')(x)
    x = layers.Conv2D(32, (3, 3), padding='same', activation='relu')(x)
    x = layers.MaxPooling2D((2, 2))(x)
    
    # Block 2
    x = layers.Conv2D(64, (3, 3), padding='same', activation='relu')(x)
    x = layers.Conv2D(64, (3, 3), padding='same', activation='relu')(x)
    x = layers.MaxPooling2D((2, 2))(x)
    
    # Block 3
    x = layers.Conv2D(128, (3, 3), padding='same', activation='relu')(x)
    x = layers.Conv2D(128, (3, 3), padding='same', activation='relu')(x)
    x = layers.MaxPooling2D((2, 2))(x)
    
    # Classifier Head
    x = layers.Flatten()(x)
    x = layers.Dense(256, activation='relu')(x)
    x = layers.Dropout(0.5)(x)
    outputs = layers.Dense(num_classes, activation='softmax')(x)
    
    return models.Model(inputs, outputs, name="Custom_VGG")

# %% 4. Arsitektur Custom CNN (ResNet-Style dengan Functional API)
def residual_block(x, filters, stride=1):
    shortcut = x
    
    # Convolution 1
    x = layers.Conv2D(filters, 3, strides=stride, padding='same', use_bias=False)(x)
    x = layers.BatchNormalization()(x)
    x = layers.Activation('relu')(x)
    
    # Convolution 2
    x = layers.Conv2D(filters, 3, strides=1, padding='same', use_bias=False)(x)
    x = layers.BatchNormalization()(x)
    
    # Sesuaikan shortcut jika dimensi berubah
    if stride != 1 or shortcut.shape[-1] != filters:
        shortcut = layers.Conv2D(filters, 1, strides=stride, padding='same', use_bias=False)(shortcut)
        shortcut = layers.BatchNormalization()(shortcut)
        
    x = layers.Add()([x, shortcut])
    x = layers.Activation('relu')(x)
    return x

def build_custom_resnet(input_shape=(IMG_HEIGHT, IMG_WIDTH, 3), num_classes=NUM_CLASSES):
    """Membangun arsitektur Custom CNN menggunakan Skip/Residual Connection."""
    inputs = layers.Input(shape=input_shape)
    x = data_augmentation(inputs)
    x = layers.Rescaling(1./255)(x)
    
    # Initial Convolution
    x = layers.Conv2D(32, 3, strides=2, padding='same', use_bias=False)(x)
    x = layers.BatchNormalization()(x)
    x = layers.Activation('relu')(x)
    x = layers.MaxPooling2D(pool_size=3, strides=2, padding='same')(x)
    
    # Residual Blocks
    x = residual_block(x, 32)
    x = residual_block(x, 64, stride=2)
    x = residual_block(x, 128, stride=2)
    
    # Classifier Head
    x = layers.GlobalAveragePooling2D()(x)
    x = layers.Dense(128, activation='relu')(x)
    x = layers.Dropout(0.5)(x)
    outputs = layers.Dense(num_classes, activation='softmax')(x)
    
    return models.Model(inputs, outputs, name="Custom_ResNet")

# %% 5. Arsitektur Custom Vision Transformer (ViT) Keras Native
def build_custom_vit(input_shape=(IMG_HEIGHT, IMG_WIDTH, 3), num_classes=NUM_CLASSES, 
                     patch_size=16, embed_dim=64, num_heads=4, transformer_layers=4):
    """Membangun Vision Transformer sederhana dari awal menggunakan Keras."""
    inputs = layers.Input(shape=input_shape)
    x = data_augmentation(inputs)
    x = layers.Rescaling(1./255)(x)
    
    # Patch Extraction & Projection (menggunakan Conv2D)
    x = layers.Conv2D(embed_dim, kernel_size=patch_size, strides=patch_size, padding="VALID")(x)
    
    # Hitung jumlah patch (sequence length)
    seq_len = (input_shape[0] // patch_size) * (input_shape[1] // patch_size)
    x = layers.Reshape((seq_len, embed_dim))(x)
    
    # Position Embedding
    positions = tf.range(start=0, limit=seq_len, delta=1)
    pos_emb = layers.Embedding(input_dim=seq_len, output_dim=embed_dim)(positions)
    x = x + pos_emb
    
    # Transformer Encoder Blocks
    for _ in range(transformer_layers):
        x1 = layers.LayerNormalization(epsilon=1e-6)(x)
        attention_output = layers.MultiHeadAttention(num_heads=num_heads, key_dim=embed_dim, dropout=0.1)(x1, x1)
        x2 = layers.Add()([attention_output, x])
        
        x3 = layers.LayerNormalization(epsilon=1e-6)(x2)
        x3 = layers.Dense(embed_dim * 2, activation=tf.nn.gelu)(x3)
        x3 = layers.Dropout(0.1)(x3)
        x3 = layers.Dense(embed_dim)(x3)
        x3 = layers.Dropout(0.1)(x3)
        
        x = layers.Add()([x3, x2])
        
    # Classifier Head
    x = layers.LayerNormalization(epsilon=1e-6)(x)
    x = layers.GlobalAveragePooling1D()(x)
    x = layers.Dropout(0.5)(x)
    outputs = layers.Dense(num_classes, activation="softmax")(x)
    
    return models.Model(inputs, outputs, name="Custom_ViT")

# %% 6. Pretrained Models dengan Transfer Learning (VGG16 / ResNet50)
def build_pretrained_model(model_type='vgg16', input_shape=(IMG_HEIGHT, IMG_WIDTH, 3), num_classes=NUM_CLASSES):
    """Menggunakan Pretrained Model dengan Transfer Learning (Base di-freeze)."""
    inputs = layers.Input(shape=input_shape)
    x = data_augmentation(inputs)
    
    if model_type == 'vgg16':
        base_model = VGG16(weights='imagenet', include_top=False, input_shape=input_shape)
        x = tf.keras.applications.vgg16.preprocess_input(x)
    elif model_type == 'resnet50':
        base_model = ResNet50(weights='imagenet', include_top=False, input_shape=input_shape)
        x = tf.keras.applications.resnet50.preprocess_input(x)
    else:
        raise ValueError("Pilih 'vgg16' atau 'resnet50'")

    # Freeze Base Model
    base_model.trainable = False
    
    x = base_model(x, training=False)
    x = layers.GlobalAveragePooling2D()(x)
    x = layers.Dense(256, activation='relu')(x)
    x = layers.Dropout(0.5)(x)
    outputs = layers.Dense(num_classes, activation='softmax')(x)
    
    model_name = f"Pretrained_{model_type.upper()}"
    return models.Model(inputs, outputs, name=model_name)

# %% 7. Pretrained Vision Transformer (Menggunakan KerasHub)
def build_pretrained_vit_hf(input_shape=(IMG_HEIGHT, IMG_WIDTH, 3), num_classes=NUM_CLASSES):
    """Membangun model pretrained ViT menggunakan KerasHub."""
    import keras_hub

    inputs = layers.Input(shape=input_shape)
    x = data_augmentation(inputs)
    
    # Model ViT bawaan KerasHub optimal di ukuran 224x224
    x = layers.Resizing(224, 224)(x)
    # Preprocessing standar ViT (nilai pixel antara 0 hingga 1)
    x = layers.Rescaling(1./255)(x)

    # Download Pretrained ViT Backbone
    vit_backbone = keras_hub.models.ViTBackbone.from_preset(
        "hf://google/vit-base-patch16-224",
        trainable=False
    )

    # Ekstraksi fitur
    x = vit_backbone(x)
    
    # Ratakan fitur (karena output berupa token sequences)
    x = layers.GlobalAveragePooling1D()(x)

    # Classification Head khusus untuk dataset
    x = layers.Dense(256, activation='relu')(x)
    x = layers.Dropout(0.5)(x)
    outputs = layers.Dense(num_classes, activation='softmax')(x)

    return models.Model(inputs, outputs, name="Pretrained_ViT_KerasHub")

# %% 8. Fungsi Pelatihan dan Evaluasi (Helper Functions)
def train_and_evaluate(model, train_data, val_data, epochs=EPOCHS):
    """Melatih model, mencetak history, dan membuat laporan evaluasi lengkap."""
    print(f"\n{'='*50}\nMemulai Training untuk {model.name}\n{'='*50}")
    
    model.compile(optimizer='adam', 
                  loss='categorical_crossentropy', 
                  metrics=['accuracy'])
    
    # Callbacks (Early Stopping & Model Checkpoint)
    callbacks = [
        tf.keras.callbacks.EarlyStopping(patience=5, restore_best_weights=True),
        tf.keras.callbacks.ModelCheckpoint(filepath=f"results/{model.name}_best.keras", save_best_only=True)
    ]
    
    history = model.fit(
        train_data,
        validation_data=val_data,
        epochs=epochs,
        callbacks=callbacks
    )
    
    # 8a. Plot Accuracy dan Loss
    plot_training_history(history, model.name)
    
    # 8b. Prediksi & Classification Report & Confusion Matrix
    evaluate_and_save_report(model, val_data, model.name)
    
    return history

def plot_training_history(history, model_name):
    """Simpan dan tampilkan grafik Accuracy & Loss."""
    acc = history.history['accuracy']
    val_acc = history.history['val_accuracy']
    loss = history.history['loss']
    val_loss = history.history['val_loss']

    plt.figure(figsize=(12, 5))
    
    plt.subplot(1, 2, 1)
    plt.plot(acc, label='Train Accuracy')
    plt.plot(val_acc, label='Validation Accuracy')
    plt.title(f'Accuracy: {model_name}')
    plt.legend()

    plt.subplot(1, 2, 2)
    plt.plot(loss, label='Train Loss')
    plt.plot(val_loss, label='Validation Loss')
    plt.title(f'Loss: {model_name}')
    plt.legend()

    plot_path = f"results/{model_name}_history.png"
    plt.savefig(plot_path)
    plt.show()
    print(f"Grafik training disimpan di: {plot_path}")

def evaluate_and_save_report(model, val_data, model_name):
    """Membuat dan menyimpan Confusion Matrix serta Classification Report."""
    print(f"Melakukan evaluasi dataset validasi pada {model_name}...")
    
    y_true = []
    y_pred = []
    
    for images, labels in val_data:
        preds = model.predict(images, verbose=0)
        y_true.extend(np.argmax(labels.numpy(), axis=1))
        y_pred.extend(np.argmax(preds, axis=1))
        
    y_true = np.array(y_true)
    y_pred = np.array(y_pred)
    
    # Classification Report
    report = classification_report(y_true, y_pred, target_names=class_names)
    print(f"\nClassification Report - {model_name}:\n")
    print(report)
    
    report_path = f"results/{model_name}_report.txt"
    with open(report_path, 'w') as f:
        f.write(f"Classification Report - {model_name}\n\n")
        f.write(report)
        
    # Confusion Matrix
    cm = confusion_matrix(y_true, y_pred)
    plt.figure(figsize=(10, 8))
    sns.heatmap(cm, annot=True, fmt='d', cmap='Blues', 
                xticklabels=class_names, yticklabels=class_names)
    plt.title(f'Confusion Matrix: {model_name}')
    plt.ylabel('True Label')
    plt.xlabel('Predicted Label')
    plt.xticks(rotation=45)
    plt.tight_layout()
    
    cm_path = f"results/{model_name}_confusion_matrix.png"
    plt.savefig(cm_path)
    plt.show()
    print(f"Evaluasi selesai. Hasil disimpan di folder 'results/'.\n")

# %% 9. Eksekusi Eksperimen
if __name__ == "__main__":
    print("Pilih model yang ingin dijalankan dengan menghapus tanda # pada baris di bawah")
    
    # 1. Custom VGG
    model_vgg = build_custom_vgg()
    train_and_evaluate(model_vgg, train_dataset, val_dataset)
    
    # 2. Custom ResNet
    model_resnet = build_custom_resnet()
    train_and_evaluate(model_resnet, train_dataset, val_dataset)
    
    # 3. Custom ViT
    model_vit_custom = build_custom_vit()
    train_and_evaluate(model_vit_custom, train_dataset, val_dataset)
    
    # 4. Pretrained VGG16
    model_pre_vgg = build_pretrained_model('vgg16')
    train_and_evaluate(model_pre_vgg, train_dataset, val_dataset)
    
    # 5. Pretrained ResNet50
    model_pre_resnet = build_pretrained_model('resnet50')
    train_and_evaluate(model_pre_resnet, train_dataset, val_dataset)
    
    # 6. Pretrained ViT (KerasHub) - Membutuhkan: !pip install keras-hub
    model_pre_vit = build_pretrained_vit_hf()
    train_and_evaluate(model_pre_vit, train_dataset, val_dataset)
