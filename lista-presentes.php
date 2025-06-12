<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Convite de Aniversário - 1 Ano da Heleninha</title>
  <link href="assets/img/favicon-32x32.png" rel="icon" type="image/png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/style.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-pink-200 via-purple-200 to-blue-200 min-h-screen flex items-center justify-center">
  <canvas id="fireworksCanvas"></canvas>  
  <div class="max-w-lg mx-auto bg-white p-3 rounded-lg shadow-lg text-center">
    <div style="text-align: left;">
        <a href="index.html" class="icon" title="Home"><i class="fas fa-home"></i></a>
        &nbsp;
        <a href="lista-presentes.html" class="icon icon-selected" title="Lista de Presentes"><i class="fas fa-list"></i></a>
    </div>
    <img src="assets/img/HEAD-HELENA.png" alt="1º Aniversário da Heleninha" class="mx-auto mb-6 rounded-lg" />
    <h1 class="text-4xl font-bold text-pink-600 mb-4" style="font-size: 27px !important;">1º Aniversário da Heleninha!</h1>
    <p class="text-lg text-gray-700 mb-4" style="font-size: 14px !important;">
      Sua presença é o que mais importa, mas, se quiser me surpreender com um mimo, aqui estão algumas sugestões! 
    </p>
    <p class="text-lg text-gray-700 mb-4" style="font-size: 14px !important; color: #007bff;">
        Caso você compre alguma das sugestões da minha lista, por favor, avise-me clicando no botão <strong style="color: #ff00c8;">COMPREI</strong>.
    </p>
        
    <!-- Link para Lista de Presentes -->
     <?php 
        require('actions/controller.php'); 
        $presents = loadPresentList();
     ?>
    <div class="mb-8">
      <table cellpadding="2" cellspacing="2" style="border: solid 1px #dedede;" width="100%" class="rounded-table">
        <tbody>
             <?php if (empty($presents)): ?>
                <tr>
                    <td class="no-data"><strong>Todas as sugestões já foram atendidas, mas use seu bom gosto!</strong></td>
                </tr>
             <?php else: ?>

                <?php foreach ($presents as $present): ?>
                    <tr>
                        <td width="70"><img src="assets/img-produto/<?php echo htmlspecialchars($present['image']);?>" class="table-presents-img"/></td>
                        <td align="left"><a href="<?php echo htmlspecialchars($present['link']); ?>" target="_blank"><?php echo htmlspecialchars($present['name']); ?></a></td>
                        <td width="80"><a href="#" class="inline-block bg-btn-gray text-white font-semibold py-2 px-4 rounded hover:bg-pink-600 transition">COMPREI</a></td>
                    </tr>
                <?php endforeach; ?>

            <?php endif; ?>        
        </tbody>
      </table>
    </div>
  </div>
  <script>

        function showConfirmation(idItem) {
            if (confirm("Você confirmar que fez a compra desse item?")) {
                alert("Compra confirmada! \n Obrigado pela sua informação!");
            } 
            return false; // Evita o comportamento padrão do link
        }


        const canvas = document.getElementById('fireworksCanvas');
        const ctx = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        class Particle {
            constructor(x, y, color) {
                this.x = x;
                this.y = y;
                this.color = color;
                this.radius = Math.random() * 2 + 1;
                this.speed = Math.random() * 5 + 2;
                this.angle = Math.random() * Math.PI * 2;
                this.vx = Math.cos(this.angle) * this.speed;
                this.vy = Math.sin(this.angle) * this.speed;
                this.alpha = 1;
                this.decay = Math.random() * 0.015 + 0.005;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;
                this.vy += 0.05; // Gravidade
                this.alpha -= this.decay;
            }

            draw() {
                ctx.save();
                ctx.globalAlpha = this.alpha;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = this.color;
                ctx.fill();
                ctx.restore();
            }
        }

        class Firework {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = canvas.height;
                this.targetY = Math.random() * canvas.height * 0.5;
                this.color = `hsl(${Math.random() * 360}, 100%, 50%)`;
                this.particles = [];
                this.exploded = false;
                this.speed = Math.random() * 5 + 5;
            }

            update() {
                if (!this.exploded) {
                    this.y -= this.speed;
                    if (this.y <= this.targetY) {
                        this.explode();
                    }
                } else {
                    this.particles = this.particles.filter(p => p.alpha > 0);
                    this.particles.forEach(p => p.update());
                }
            }

            draw() {
                if (!this.exploded) {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, 3, 0, Math.PI * 2);
                    ctx.fillStyle = this.color;
                    ctx.fill();
                } else {
                    this.particles.forEach(p => p.draw());
                }
            }

            explode() {
                this.exploded = true;
                for (let i = 0; i < 100; i++) {
                    this.particles.push(new Particle(this.x, this.y, this.color));
                }
            }
        }

        const fireworks = [];

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpa o canvas completamente para fundo transparente

            if (Math.random() < 0.05) {
                fireworks.push(new Firework());
            }

            fireworks.forEach((firework, index) => {
                firework.update();
                firework.draw();
                if (firework.exploded && firework.particles.length === 0) {
                    fireworks.splice(index, 1);
                }
            });

            requestAnimationFrame(animate);
        }

        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    </script>
</body>
</html>