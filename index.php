<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>CodeQuiz - Ambiente de Questionários</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CodeQuiz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1>Bem-vindo ao CodeQuiz</h1>
            <p class="lead">
                Um ambiente interativo criado especialmente para professores que desejam aplicar questionários de programação de forma prática e envolvente.
            </p>
            <a href="#features" class="btn btn-light btn-lg mt-3">Saiba mais</a>
        </div>
    </header>

    <!-- Section: Why Use CodeQuiz -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Por que usar o CodeQuiz?</h2>
            <p class="text-center">
                O CodeQuiz foi projetado para ser o ambiente ideal para professores que desejam engajar suas turmas com atividades práticas de programação.
                Com uma interface simples e intuitiva, ele permite criar e aplicar questionários diretamente para os alunos, em qualquer contexto: seja em sala de aula ou remotamente.
            </p>
            <p class="text-center">
                Mais do que uma ferramenta de avaliação, o CodeQuiz oferece um espaço dinâmico que incentiva o aprendizado interativo, conectando o professor ao aluno de forma efetiva e moderna.
            </p>
        </div>
    </section>

    <!-- Section: How It Works -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Como funciona?</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <span class="badge bg-primary rounded-pill p-3 fs-4">1</span>
                    </div>
                    <h5>Professores criam questionários</h5>
                    <p>Crie questões adaptadas ao nível de sua turma. Use desde perguntas teóricas até exercícios práticos de código.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <span class="badge bg-primary rounded-pill p-3 fs-4">2</span>
                    </div>
                    <h5>Turmas recebem e respondem</h5>
                    <p>Os alunos acessam os questionários de forma prática e realizam as atividades no tempo definido pelo professor.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <span class="badge bg-primary rounded-pill p-3 fs-4">3</span>
                    </div>
                    <h5>Resultados organizados</h5>
                    <p>O sistema organiza automaticamente os resultados, facilitando a análise do desempenho da turma.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Call to Action -->
    <section class="py-5">
        <div class="container text-center">
            <h2>Professores, comecem agora!</h2>
            <p class="mb-4">
                Transforme a forma como avalia suas turmas. Experimente o CodeQuiz e veja como é simples criar e aplicar questionários em programação.
            </p>
            <a href="Telas/Login.php" class="btn btn-primary btn-lg">Criar Meu Primeiro Questionário</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p class="mb-0">© 2024 CodeQuiz. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
