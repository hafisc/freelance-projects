@extends('layouts.app')

@section('title', 'Fisitera - Media Pembelajaran Interaktif')

@section('style')
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-blue: #229add;
      --dark-text: #2a3342;
      --gray-text: #6b7280;
      --bg-color: #eaf3fb; 
    }

    .hero-section {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-color);
      min-height: 90vh; 
      display: flex;
      align-items: center;
      padding: 60px 0;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 80px;
    }

    /* --- Sisi Kiri: Content --- */
    .hero-content {
      flex: 1.2;
    }

    .category {
      font-size: 0.95rem;
      color: var(--primary-blue);
      font-weight: 600;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .hero-content h1 {
      font-size: 3.5rem;
      line-height: 1.15;
      font-weight: 800;
      margin-bottom: 24px;
      color: var(--dark-text);
      letter-spacing: -0.5px;
    }

    .hero-content .highlight {
      color: var(--primary-blue);
    }

    .hero-content p {
      font-size: 1.1rem;
      color: var(--gray-text);
      line-height: 1.6;
      margin-bottom: 40px;
      max-width: 480px;
    }

    .cta-group {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .btn {
      padding: 14px 28px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      font-size: 1rem;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn-primary {
      background: var(--primary-blue);
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(34, 154, 221, 0.3);
    }

    .btn-primary:hover {
      background: #1c82bc;
      transform: translateY(-2px);
    }

    .btn-white {
      background: #ffffff;
      color: var(--dark-text);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
    }

    .btn-white:hover {
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
      transform: translateY(-2px);
    }

    /* --- Sisi Kanan: Visual Card --- */
    .hero-visual {
      flex: 1;
      display: flex;
      justify-content: flex-end;
    }

    .glass-card {
      background: #ffffff;
      width: 100%;
      max-width: 520px;
      height: 280px;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
      display: flex;
      flex-direction: column;
      padding: 40px;
      position: relative;
    }

    .wave-container {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .wave-svg {
      width: 110%;
      height: 100px;
      transform: scaleY(1.2);
    }

    .wave-line {
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
    }

    .line-1 { stroke: #229add; }          
    .line-2 { stroke: #8cc4e8; }          
    .line-3 { stroke: #d1cbf0; }          

    .card-footer {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 20px;
    }

    .footer-item {
      font-size: 0.9rem;
      color: var(--gray-text);
      display: flex;
      align-items: center;
      gap: 6px;
      font-weight: 500;
    }

    .footer-icon {
      width: 18px;
      height: 18px;
      stroke: var(--primary-blue);
    }

    /* --- Responsive Design --- */
    @media (max-width: 968px) {
      .container {
        flex-direction: column;
        text-align: center;
        gap: 50px;
      }
      
      .hero-content p {
        margin: 0 auto 40px;
      }

      .category, .cta-group {
        justify-content: center;
      }

      .hero-visual {
        justify-content: center;
        width: 100%;
      }
    }
  </style>
@endsection

@section('content')
  <section class="hero-section">
    <div class="container">
      
      <div class="hero-content">


        <h1>Fisitera: Fisika Interaktif <br> <span class="highlight">Gelombang, Bunyi <br> & Cahaya</span></h1>

        <p>Jelajahi konsep fisika melalui simulasi interaktif, animasi yang menarik, dan kuis menyenangkan yang dirancang khusus untuk meningkatkan pemahaman Anda.</p>

        <div class="cta-group">
          <a href="definisi_gelombang" class="btn btn-primary">
            Mulai Belajar 
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
      </div>

      <div class="hero-visual">
        <div class="glass-card">
          <div class="wave-container">
            <svg viewBox="0 0 500 100" class="wave-svg">
              <path class="wave-line line-3" d="M0,40 C80,10 120,70 200,40 C280,10 320,70 400,40 C460,15 480,30 500,40" />
              <path class="wave-line line-2" d="M0,65 C100,100 150,20 250,55 C350,90 400,20 500,55" />
              <path class="wave-line line-1" d="M0,50 C100,0 150,100 250,50 C350,0 400,100 500,50" />
            </svg>
          </div>

          <div class="card-footer">
            <span class="footer-item">
              <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h4l2-9 5 18 5-18 2 9h2"/></svg>
              Gelombang
            </span>
            <span class="footer-item">
              <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path></svg>
              Bunyi
            </span>
            <span class="footer-item">
              <svg class="footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
              Cahaya
            </span>
          </div>
        </div>
      </div>
      
    </div>
  </section>
@endsection