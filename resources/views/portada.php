<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            /* --primary-color: #003d7d; */
            --primary-color: #8b0e13;
            --secondary-color: #333;
            --accent-color: #8b0e13;
            --text-color: #333;
            --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.4;
            color: var(--text-color);
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
            padding: 1.5rem;
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            background-color: var(--primary-color);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .logo {
            max-width: 150px;
            height: auto;
            display: block;
            margin: 0 auto;
            filter: brightness(0) invert(1);
        }

        .header {
            text-align: center;
            padding: 0.8rem;
            border-bottom: 2px solid var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .faculty-name,
        .school-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .course-info {
            font-size: 1rem;
            color: var(--accent-color);
            margin-bottom: 0.3rem;
        }

        .project-section {
            text-align: center;
            padding: 1.2rem;
            background: linear-gradient(to right, #f8f9fa, #ffffff, #f8f9fa);
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .project-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 1.2rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .group-info,
        .tutor-info {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: var(--accent-color);
            font-weight: bold;
        }

        .members-table-container {
            border-radius: 8px;
            background: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
            margin-bottom: 1.5rem;
        }

        .members-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .members-table th,
        .members-table td {
            padding: 0.7rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .members-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .members-table tr:last-child td {
            border-bottom: none;
        }

        .members-table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .date {
            text-align: center;
            font-size: 1rem;
            font-weight: bold;
            color: var(--primary-color);
            padding: 0.8rem;
            border-top: 2px solid var(--primary-color);
        }

        @media screen and (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .container {
                padding: 1rem;
            }

            .faculty-name,
            .school-name {
                font-size: 1.1rem;
            }

            .course-info {
                font-size: 0.9rem;
            }

            .project-title {
                font-size: 1.2rem;
            }

            .subtitle {
                font-size: 1.1rem;
            }

            .members-table th,
            .members-table td {
                padding: 0.6rem;
                font-size: 0.85rem;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                padding: 0.8rem;
            }

            .logo {
                max-width: 120px;
            }

            .faculty-name,
            .school-name {
                font-size: 1rem;
            }

            .project-title {
                font-size: 1.1rem;
            }

            .subtitle {
                font-size: 0.9rem;
            }

            .members-table th,
            .members-table td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }

            .group-info,
            .tutor-info {
                font-size: 0.9rem;
            }

            .date {
                font-size: 0.9rem;
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container>* {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img class="logo" src="https://www.ues.edu.sv/wp-content/uploads/sites/20/2021/04/light-header-v2-vertical.png" alt="Logo UES">
        </div>

        <div class="header">
            <div class="faculty-name">FACULTAD DE INGENIERÍA Y ARQUITECTURA</div>
            <div class="school-name">ESCUELA DE INGENIERÍA EN SISTEMAS INFORMÁTICOS</div>
            <div class="course-info">TECNOLOGÍAS ORIENTADAS A OBJETOS (TOO-115)</div>
            <div class="course-info">CICLO II - 2024</div>
        </div>

        <div class="project-section">
            <div class="project-title">"INTELLIGENT SOLUTIONS AND CONSTRUCTIONS"</div>
            <div class="subtitle">Tema: "Sistema de Gestión de Productos Cárnicos (SGPC)"</div>
            <div class="group-info">GT 02 - GRUPO 03</div>
            <div class="tutor-info">TUTOR: INGA. YENY AYALA</div>
        </div>

        <div class="members-table-container">
            <table class="members-table">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>CARNET</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Helen Jazmin Alvarado Landaverde</td>
                        <td>AL20006</td>
                    </tr>
                    <tr>
                        <td>Cristian Alexis García Ascencio</td>
                        <td>GA17033</td>
                    </tr>
                    <tr>
                        <td>Jonathan Bryan Henríquez Álvarez</td>
                        <td>HA22023</td>
                    </tr>
                    <tr>
                        <td>Kevin Noé Lemus Fuentes</td>
                        <td>LF18010</td>
                    </tr>
                    <tr>
                        <td>Alexis Alexander Deras Orellana</td>
                        <td>OD18003</td>
                    </tr>
                    <tr>
                        <td>Carlos Eduardo Rafaelano Santos</td>
                        <td>RS20002</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="date" id="currentDate"></div>
    </div>

    <script>
        function formatDate() {
            const date = new Date();
            const months = [
                "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO",
                "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"
            ];

            const day = date.getDate();
            const month = months[date.getMonth()];
            const year = date.getFullYear();

            document.getElementById('currentDate').textContent =
                `CIUDAD UNIVERSITARIA, ${day} DE ${month} DE ${year}`;
        }
        formatDate();
    </script>
</body>

</html>