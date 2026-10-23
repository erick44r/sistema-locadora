<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locação de Máquinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <style>
        #logo {
            height: 70px;
            width: 70px;
        }
        #imgExemplo {
            height: 300px;
            width: auto;
        }
        .galeria-img {
            width: 100%;
            height: 260px;
            object-fit: cover;
        }
        .card-img-top{
            height: 220px;
            object-fit: cover;
        }
        </style>
</head>
<body>
    <nav class = "navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                Locação de Máquinas
            </a>
                <button class="navbar-toggler" type ="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"> <a class=" nav-link active" href="#home">Home</a></li>
                        <li class="nav-item"> <a class=" nav-link" href="#maquinas">Máquinas</a></li>
                        <li class="nav-item"> <a class=" nav-link" href="#servicos">Serviços</a></li>
                        <li class="nav-item"> <a class=" nav-link" href="#galeria">Galeria</a></li>
                        <li class="nav-item"> <a class=" nav-link" href="#precos">Preços</a></li>
                        <li class="nav-item"> <a class=" nav-link" href="{{ route('contato') }}" target="_blank">Contato</a></li>
                        <li class="nav-item"> <a class="nav-link fw-bold text-warning" href="{{ route('dashboard') }}">Área Administrativa</a></li>
                    </ul>
                </div>
        </div>
    </nav>

            <header id="home" class="vh-100 bg-secondary text-white d-flex align-items-center justify-content-center text-center position-relative" style=" background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFuCGLsYOp-Y1QeQfn5nhQDxdQqNsBUuLhetTWLCAXQQlB-8PlED5p9tDm&s=10') center/cover no-repeat;">
                <div class="container">
                        <h1 class="display-3 fw-bold">Locação de Máquinas para Construção e obras</h1>
                        <p class="lead"> As melhores máquinas para que sua obra seja nota 10!!!</p>
                        <a href="#maquinas" class="btn btn-warning btn-lg mt-3">Ver Máquinas</a>
                </div>
            </header>

            <section id="maquinas" class="py-5 bg-light">
                <div class="container">
                    <h2 class="text-center mb-4">Máquinas em Destaque</h2>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0gXPjVlsLHbjb89NWa5Qqp_reVVjB99YYcAX_DeFOiEoWN5H_X6vYyM82&s=10" alt="Escavadeira" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title">Escavadeira Hidraúlica</h5>
                                            <p class="card-text"> Alta perfomance para escavações profundas e movimentação de terra.</p>
                                        </div>
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRYvCWgbaTKMSSNPYehrTEM9QWaMVU2kzvJ-XSmxGj22gFJ--K0nXGCSdmL&s=10" alt="Pá carregadeira" class="card-img-top">                                    
                                        <div class="card-body">
                                            <h5 class="card-title">Pá Carregadeira</h5>
                                            <p class="card-text">Ideal para carregamento de materiais pesados e nivelamento do solo.</p>

                                        </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLVmmVM1Z7L45CG0b0Dpesl90ZmbkGs0LBQOSJ6MSyDw&s=10" class="card-img-top" alt="Retroescavadeira">
                                    <div class="card-body">
                                            <h5 class="card-title">Retroescavadeira</h5>
                                    <p class="card-text">Versatilidade para obras urbanas e rurais com duplo sistema de operação</p>

                                    </div>
                                    


                                     
                                </div>
                            </div>
                        </div>
                </div>
            </section>

            <section id="servicos" class="py-5">
                    <div class="container">
                        <h2 class="text-center mb-4">Nossos Serviços</h2>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-4 border rounded bg-white h-100">
                                        <h4>Locação com Operador</h4>
                                        <p class="mb-0"> Profissionais qualificados e certificados para operar os equipamento com total segurança para sua obra</p>

                                    </div>

                                </div>
                                    <div class="col-md-6">
                                        <div class="p-4 border rounded bg-white h-100">
                                            <h4>Manutenção Preventiva e Assistência</h4>
                                            <p class="mb-0">Suporte técnico rápido no local com substituição de peças para garantir zero paradas na operação</p>


                                        </div>

                                    </div>
                            </div>

                    </div>
            </section>

            <section id="galeria" class="py-5 bg-light">
                <div class="container">
                    <h2 class="text-center mb-4">Galeria de Fotos</h2>
                    <div class="row g-3">
                       <div class="col-6 col-md-4" ><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR23ySI_WI4-B74QJx896FwblufxZoyzignz7ON04cPjE5akaJh_KQJ9P6q&s=10" class="img-fluid rounded galeria-img" alt="Obra 1"></div> 
                       <div class="col-6 col-md-4" ><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRU0_Fj0G4CQsVH3JXOPP43ZZHTxIGbyB66R7ZqhkcNgxF1UyVvRRchNPZc&s=10" class="img-fluid rounded galeria-img" alt="Obra 2"></div> 
                       <div class="col-6 col-md-4" ><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSc5pX0QbD1pPFOc-Jkm7b5rfXtIgs7OU9B0I16YTbfV4XM0nxTQSnk2Olg&s=10" class="img-fluid rounded galeria-img"  alt="Obra 3"></div> 
                    </div>
                </div>
            </section>

            <section id="precos" class="py-5">
                <div class="container">
                    <h2 class="text-center mb-4"> Tabela de valores da Locação</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover border">
                            <thead class="table-dark">
                                <tr>
                                    <th>Equipamento</th>                                    
                                    <th>Diária</th>                                    
                                    <th>Semanal</th>                                    
                                    <th>Mensal</th>                                                                                                
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Escavadeira Hidráulica</td>
                                    <td>R$ 1.200,00</td>
                                    <td>R$ 7.200,00</td>
                                    <td>R$ 24.000,00</td>                                
                                </tr>
                                <tr>
                                    <td>Pá Carregadeira</td>
                                    <td>R$ 950,00</td>
                                    <td>R$ 5.500,00</td>
                                    <td>R$ 19.000,00</td>                                
                                </tr>
                                <tr>
                                   <td>Retroescavadeira</td>
                                   <td>R$ 800,00</td>
                                   <td>R$ 4.800,00</td>
                                   <td>R$ 16.000,00</td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>