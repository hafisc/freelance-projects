class Particle {
  constructor(w, h) {
    this.screenW = w;
    this.screenH = h;
    this.x = Math.random() * w;
    this.y = Math.random() * h;
    this.targetX = this.x;
    this.targetY = this.y;
    this.targetZ = 0;
    this.originalTargetX = this.x;
    this.originalTargetY = this.y;
    this.originalTargetZ = 0;
    this.rotatable = false;
    this.is3D = false;
    this.vx = (Math.random() - 0.5) * 1;
    this.vy = Math.random() * 3 + 1;
    this.radius = Math.random() * 1.5 + 0.5;
    const brightness = Math.floor(Math.random() * 55 + 200);
    this.color = `rgba(56, 189, ${brightness}, 0.8)`;
    this.friction = 0.88;
    this.ease = 0.04 + Math.random() * 0.04;
    this.isFalling = true;
    this.isFormingShape = false;
  }

  update(mouse) {
    if (this.isFalling) {
      this.y += this.vy;
      this.x += this.vx;
      if (this.y > this.screenH) {
        this.y = -10;
        this.x = Math.random() * this.screenW;
      }
    } else {
      const dx = this.targetX - this.x;
      const dy = this.targetY - this.y;
      this.vx += dx * this.ease;
      this.vy += dy * this.ease;

      const mdx = this.x - mouse.x;
      const mdy = this.y - mouse.y;
      const distance = Math.sqrt(mdx * mdx + mdy * mdy);
      if (distance < mouse.radius) {
        const forceDirectionX = mdx / distance;
        const forceDirectionY = mdy / distance;
        const force = (mouse.radius - distance) / mouse.radius;
        this.vx += forceDirectionX * force * 8;
        this.vy += forceDirectionY * force * 8;
      }

      this.vx *= this.friction;
      this.vy *= this.friction;
      this.x += this.vx;
      this.y += this.vy;
    }
  }

  draw(ctx) {
    ctx.fillStyle = this.color;
    ctx.beginPath();
    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
    ctx.fill();
  }
}

function getTextCoordinates(text, width, height, fontSize) {
  const canvas = document.createElement('canvas');
  canvas.width = width;
  canvas.height = height;
  const ctx = canvas.getContext('2d', { willReadFrequently: true });

  ctx.fillStyle = 'white';
  ctx.font = `bold ${fontSize}px "Outfit", sans-serif`;
  ctx.textAlign = 'center';
  ctx.textBaseline = 'middle';

  if (text === "my whole universe") {
    const lineSpacing = fontSize * 1.2;
    ctx.fillText("my whole", width / 2, height / 2 - lineSpacing / 2);
    ctx.fillText("universe", width / 2, height / 2 + lineSpacing / 2);
  } else {
    ctx.fillText(text, width / 2, height / 2);
  }

  return getCoordinatesFromCanvas(ctx, width, height, 4);
}

function generate3DPlanet(width, height, radius) {
    const targets = [];
    const cx = width / 2;
    const cy = height / 2;
    
    // Permukaan Planet (Sphere)
    const sphereParticles = 1500;
    for (let i = 0; i < sphereParticles; i++) {
        const phi = Math.acos(1 - 2 * Math.random());
        const theta = Math.random() * 2 * Math.PI;
        
        const x = radius * Math.sin(phi) * Math.cos(theta);
        const y = radius * Math.sin(phi) * Math.sin(theta);
        const z = radius * Math.cos(phi);
        
        const b = Math.floor(Math.random() * 55 + 200);
        targets.push({
            x: cx + x,
            y: cy + y,
            z: z,
            color: `rgba(56, 189, ${b}, 0.8)`,
            rotatable: true,
            is3D: true
        });
    }
    
    // Cincin Planet (Rings)
    const ringParticles = 1200;
    for (let i = 0; i < ringParticles; i++) {
        let r;
        const rand = Math.random();
        if (rand < 0.33) r = radius * 1.3 + Math.random() * 10;
        else if (rand < 0.66) r = radius * 1.6 + Math.random() * 15;
        else r = radius * 1.9 + Math.random() * 20;
        
        const theta = Math.random() * 2 * Math.PI;
        const x = r * Math.cos(theta);
        const y = (Math.random() - 0.5) * 8; // Ketebalan cincin
        const z = r * Math.sin(theta);
        
        const b = Math.floor(Math.random() * 55 + 200);
        targets.push({
            x: cx + x,
            y: cy + y,
            z: z,
            color: `rgba(56, 189, ${b}, 0.8)`,
            rotatable: true,
            is3D: true
        });
    }
    return targets;
}

function getPlanetCoordinates(width, height, radius) {
  return generate3DPlanet(width, height, radius);
}

function getPlanetWithTextCoordinates(width, height, radius, text) {
  const planetTargets = generate3DPlanet(width, height, radius);

  // --- Kanvas terpisah untuk Teks ---
  const textCanvas = document.createElement('canvas');
  textCanvas.width = width;
  textCanvas.height = height;
  const textCtx = textCanvas.getContext('2d', { willReadFrequently: true });
  
  textCtx.fillStyle = 'white';
  textCtx.font = `bold ${radius * 0.5}px "Outfit", sans-serif`;
  textCtx.textAlign = 'center';
  textCtx.textBaseline = 'middle';
  textCtx.fillText(text, width / 2, height / 2);
  
  const textTargets = getCoordinatesFromCanvas(textCtx, width, height, 4);

  // Gabungkan kedua hasil agar tidak saling melubangi
  return planetTargets.concat(textTargets);
}

function getCoordinatesFromCanvas(ctx, width, height, step = 4) {
  const pixels = ctx.getImageData(0, 0, width, height).data;
  const coordinates = [];

  for (let y = 0; y < height; y += step) {
    for (let x = 0; x < width; x += step) {
      const index = (y * width + x) * 4;
      const r = pixels[index];
      const alpha = pixels[index + 3];
      if (alpha > 50) {
        const b = Math.floor(Math.random() * 55 + 200);
        const targetAlpha = alpha / 255;
        let color = '';
        let rotatable = false;
        if (r > 128) {
          // Teks berwarna putih (tidak ikut berputar)
          color = `rgba(${b}, ${b}, ${b}, ${targetAlpha})`;
          rotatable = false;
        } else {
          // Planet/Hujan berwarna biru (ikut berputar)
          color = `rgba(56, 189, ${b}, ${targetAlpha})`;
          rotatable = true;
        }
        coordinates.push({
          x,
          y,
          color: color,
          rotatable: rotatable
        });
      }
    }
  }
  return coordinates;
}

const canvas = document.getElementById('scene');
const ctx = canvas.getContext('2d', { willReadFrequently: true });
let particles = [];
let currentRotation = 0;
let isPlanetScene = false;

const mouse = { x: -1000, y: -1000, radius: 100 };

function resize() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  particles.forEach(p => {
    p.screenW = canvas.width;
    p.screenH = canvas.height;
  });
}

window.addEventListener('resize', resize);
window.addEventListener('mousemove', (e) => {
  mouse.x = e.clientX;
  mouse.y = e.clientY;
});
window.addEventListener('touchmove', (e) => {
  mouse.x = e.touches[0].clientX;
  mouse.y = e.touches[0].clientY;
});
window.addEventListener('touchend', () => {
  mouse.x = -1000;
  mouse.y = -1000;
});
window.addEventListener('mouseout', () => {
  mouse.x = -1000;
  mouse.y = -1000;
});

function initParticles(count) {
  particles = [];
  for (let i = 0; i < count; i++) {
    particles.push(new Particle(canvas.width, canvas.height));
  }
}

function updateTargets(targets) {
  if (targets.length > particles.length) {
    const diff = targets.length - particles.length;
    for (let i = 0; i < diff; i++) {
      particles.push(new Particle(canvas.width, canvas.height));
    }
  }

  // Acak urutan partikel agar tidak membentuk sisa bayangan (ghost shape) dari angka sebelumnya
  particles.sort(() => Math.random() - 0.5);

  for (let i = 0; i < particles.length; i++) {
    if (i < targets.length) {
      particles[i].targetX = targets[i].x;
      particles[i].targetY = targets[i].y;
      particles[i].targetZ = targets[i].z || 0;
      particles[i].originalTargetX = targets[i].x;
      particles[i].originalTargetY = targets[i].y;
      particles[i].originalTargetZ = targets[i].z || 0;
      particles[i].color = targets[i].color;
      particles[i].rotatable = targets[i].rotatable;
      particles[i].is3D = targets[i].is3D || false;

      if (particles[i].isFalling) {
        particles[i].isFalling = false;
      }
      particles[i].isFormingShape = true;
    } else {
      if (particles[i].isFormingShape) {
        // Pindahkan partikel sisa bentuk sebelumnya kembali ke atas
        particles[i].y = -Math.random() * canvas.height;
        particles[i].x = Math.random() * canvas.width;
        particles[i].isFormingShape = false;
        // Kembalikan warna ke biru (hujan)
        const b = Math.floor(Math.random() * 55 + 200);
        particles[i].color = `rgba(56, 189, ${b}, 0.8)`;
      }
      particles[i].isFalling = true;
    }
  }
}

function animate() {
  ctx.fillStyle = 'rgba(2, 6, 23, 0.3)';
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  if (isPlanetScene) {
      currentRotation += 0.005; // Kecepatan rotasi
      const cx = canvas.width / 2;
      const cy = canvas.height / 2;
      const cos = Math.cos(currentRotation);
      const sin = Math.sin(currentRotation);
      const tiltCos = Math.cos(0.4); // Kemiringan cincin (sekitar 23 derajat)
      const tiltSin = Math.sin(0.4);
      
      for (const p of particles) {
          if (p.isFormingShape) {
              if (p.rotatable && p.is3D) {
                  let x = p.originalTargetX - cx;
                  let y = p.originalTargetY - cy;
                  let z = p.originalTargetZ;
                  
                  // Rotasi sumbu Y (agar planet berputar)
                  let x1 = x * cos - z * sin;
                  let z1 = x * sin + z * cos;
                  
                  // Miringkan pada sumbu X agar cincin terlihat diagonal
                  let y2 = y * tiltCos - z1 * tiltSin;
                  
                  p.targetX = cx + x1;
                  p.targetY = cy + y2;
              } else if (p.rotatable) {
                  // Fallback 2D
                  const dx = p.originalTargetX - cx;
                  const dy = p.originalTargetY - cy;
                  p.targetX = cx + dx * cos - dy * sin;
                  p.targetY = cy + dx * sin + dy * cos;
              } else {
                  p.targetX = p.originalTargetX;
                  p.targetY = p.originalTargetY;
              }
          }
      }
  } else {
    currentRotation = 0;
  }

  for (const p of particles) {
    p.update(mouse);
    p.draw(ctx);
  }

  requestAnimationFrame(animate);
}

function delay(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function startSequence() {
  const audio = document.getElementById('bgm');
  audio.play().catch(e => console.error("Audio playback failed", e));

  const uiLayer = document.getElementById('ui-layer');
  if (uiLayer) {
    uiLayer.classList.add('hidden');
  }

  const getNumSize = () => Math.min(canvas.width * (canvas.width < 768 ? 0.8 : 0.5), 350);
  
  const getTextSize = (text) => {
      let scale = 0.18;
      if (canvas.width < 768) {
          if (text.length <= 2) scale = 0.4; // "my"
          else if (text.length <= 5) scale = 0.28; // "whole"
          else scale = 0.18; // "universe"
      }
      return Math.min(canvas.width * scale, 200);
  };
  
  const getRadius = () => Math.min(canvas.width, canvas.height) * 0.35;

  updateTargets(getTextCoordinates("3", canvas.width, canvas.height, getNumSize()));
  await delay(2000);

  updateTargets(getTextCoordinates("2", canvas.width, canvas.height, getNumSize()));
  await delay(2000);

  updateTargets(getTextCoordinates("1", canvas.width, canvas.height, getNumSize()));
  await delay(2000);

  particles.forEach(p => p.isFalling = true);
  await delay(500);

  // Kata per kata
  updateTargets(getTextCoordinates("my", canvas.width, canvas.height, getTextSize("my")));
  await delay(3500);

  updateTargets(getTextCoordinates("whole", canvas.width, canvas.height, getTextSize("whole")));
  await delay(3500);

  updateTargets(getTextCoordinates("universe", canvas.width, canvas.height, getTextSize("universe")));
  await delay(4500);

  particles.forEach(p => p.isFalling = true);
  await delay(500);

  isPlanetScene = true;
  updateTargets(getPlanetCoordinates(canvas.width, canvas.height, getRadius()));
  await delay(3500);

  updateTargets(getPlanetWithTextCoordinates(canvas.width, canvas.height, getRadius(), "is you"));
}

resize();
initParticles(6000);
animate();

const startBtn = document.getElementById('start-btn');
if (startBtn) {
  startBtn.addEventListener('click', () => {
    startSequence();
  });
}
