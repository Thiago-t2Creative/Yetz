@extends('layout.site')

@section('content')
    <style>
        .card {
            width: 25%;
        }

        .card-title {
            line-height: 20px !important;
            font-size: 16px !important;
            margin-bottom: -20px !important;
        }
    </style>

    <div class="row">
        <div class="col s12">

            <h5>Sorteios</h5>
            <br>

            <div class="iniciar">
                <h6>Clique no botão abaixo para iniciar o sorteio.</h6>
                <br>
                <a id="btn-iniciar" href="#" class="waves-effect waves-light btn pink darken-3">Iniciar</a>
            </div>

            <div class="confirmar-presenca hide">

                <h6>Selecione os jogadores com presença confirmada.</h6>
                <br>

                <a id="btn-selecionar-todos" href="#" class="waves-effect waves-light btn pink darken-3">Selecionar todos</a>
                <br>
                <br>

                <div class="tabela"></div>

                <br>

                <a href="#" class="waves-effect waves-light btn red" onclick="voltarInicio();">Cancelar</a>
                <a id="btn-selecionar" href="#" class="waves-effect waves-light btn pink darken-3">Avançar</a>
            </div>

            <div class="numero-jogadores hide">

                <h6>Defina o número de jogadores por time.</h6>
                <p>Total de Jogadores confirmados: <span id="total-jogadores-selecionados"></span></p>
                <p style="margin-top: -14px">Total de Goleiros confirmados: <span id="total-goleiros-selecionados"></span></p>
                <br>

                <div class="input-field col s4">
                    <select id="select-numero-jogadores"></select>
                    <label>Número de Jogadores por time</label>
                </div>

                <div class="row">
                    <div class="col s12">
                        <br>
                        <a href="#" class="waves-effect waves-light btn red" onclick="voltarInicio();">Cancelar</a>
                        <a id="btn-sortear" href="#" class="waves-effect waves-light btn pink darken-3">Sortear</a>
                    </div>
                </div>
            </div>

            <div class="sorteio hide">

                <h6>Resultado do sorteio:</h6>
                <br>

                <div id="resultado-sorteio" style="display: flex;">...</div>
                <br>

                <a href="#" class="waves-effect waves-light btn red" onclick="voltarSorteio();">Voltar</a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>

        // Array para armazenar os jogadores selecionados
        var jogadoresSelecionados = [];

        // Evento de clique no botão de iniciar
        document.getElementById('btn-iniciar').addEventListener('click', function() {
            // Esconder a seção de início e mostrar a seção de confirmação de presença
            document.querySelector('.iniciar').classList.add('hide');
            document.querySelector('.confirmar-presenca').classList.remove('hide');
            // Criar a tabela de jogadores
            criarTabelaJogadores();
        });

        // Evento de clique no botão de avançar após seleção dos jogadores
        document.getElementById('btn-selecionar').addEventListener('click', function() {
            // Limpar o array de jogadores selecionados
            jogadoresSelecionados = [];

            // Percorrer todas as checkboxes da tabela de jogadores
            var checkboxes = document.querySelectorAll('.tabela input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) { // Se a checkbox estiver marcada
                    // Obter os dados do jogador da linha correspondente
                    var row = checkbox.closest('tr');
                    var nome = row.querySelector('td:nth-child(2)').textContent;
                    var nivel = row.querySelector('td:nth-child(3)').textContent;
                    var goleiro = row.querySelector('td:nth-child(4)').textContent === 'Sim' ? 1 : 0;

                    // Adicionar jogador selecionado ao array
                    jogadoresSelecionados.push({ nome: nome, nivel: nivel, goleiro: goleiro });
                }
            });

            // Verificar se foram selecionados jogadores suficientes e goleiros suficientes
            let impedido = false;
            if (jogadoresSelecionados.length < 6) {
                showToastMsg("Selecione ao menos 6 jogadores!");
                impedido = true;
            } else if (contarGoleiros(jogadoresSelecionados) < 2) {
                showToastMsg("Selecione ao menos 2 goleiros!");
                impedido = true;
            }

            // Se não houver impedimento, avançar para seleção do número de jogadores por time
            if (!impedido) {
                document.querySelector('#total-jogadores-selecionados').innerHTML = jogadoresSelecionados.length;
                document.querySelector('#total-goleiros-selecionados').innerHTML = contarGoleiros(jogadoresSelecionados);
                document.querySelector('.confirmar-presenca').classList.add('hide');
                document.querySelector('.numero-jogadores').classList.remove('hide');
                carregarOpcoesSelect(jogadoresSelecionados.length); // Carregar opções do select
            }
        });

        // Evento de clique no botão de selecionar todos
        document.getElementById('btn-selecionar-todos').addEventListener('click', function() {
            // Marcar todas as checkboxes da tabela de jogadores
            var checkboxes = document.querySelectorAll('.tabela input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
        });

        // Evento de clique no botão de sortear
        document.getElementById('btn-sortear').addEventListener('click', function() {
            // Obter o número de jogadores por time e outros dados necessários
            var numJogadoresPorTime = parseInt(document.getElementById('select-numero-jogadores').value);
            var numGoleiros = contarGoleiros(jogadoresSelecionados);
            var numJogadoresRestantes = jogadoresSelecionados.length;

            // Verificar se há jogadores suficientes para formar pelo menos um time completo
            if (numJogadoresRestantes < numJogadoresPorTime) {
                showToastMsg("Não há jogadores suficientes para formar pelo menos um time completo.");
                return;
            }

            var numTimes = Math.floor(numJogadoresRestantes / numJogadoresPorTime);

            // Verificar se há jogadores suficientes para formar pelo menos dois times completos
            if (numTimes < 2) {
                showToastMsg("Não há jogadores suficientes para formar pelo menos dois times completos.");
                return;
            }

            var times = [];
            var banco = [];
            var jogadoresSorteados = [];

            // Ordenar os jogadores por nível
            jogadoresSelecionados.sort((a, b) => a.nivel - b.nivel);
            //console.log(jogadoresSelecionados);

            // Criar um novo array alternando entre o início e o final do array ordenado
            var novoArray = [];
            var inicio = 0;
            var fim = jogadoresSelecionados.length - 1;

            while (inicio <= fim) {
                novoArray.push(jogadoresSelecionados[inicio]);
                // Verificar se ainda há elementos no meio para evitar repetições
                if (inicio !== fim) {
                    novoArray.push(jogadoresSelecionados[fim]);
                }
                inicio++;
                fim--;
            }

            // Se houver um número ímpar de jogadores, o jogador do meio foi adicionado apenas uma vez
            // Nesse caso, podemos adicioná-lo ao final do novo array
            if (jogadoresSelecionados.length % 2 !== 0) {
                novoArray.push(jogadoresSelecionados[Math.floor(jogadoresSelecionados.length / 2)]);
            }
            //console.log(novoArray);

            // Loop para sortear os times
            for (var i = 0; i < numTimes; i++) {
                var time = []; // Array para armazenar os jogadores do time atual
                var goleiroAdicionado = false; // Flag para indicar se o goleiro já foi adicionado ao time

                // Iterar sobre os jogadores selecionados para formar o time
                novoArray.forEach(function(jogador) {
                    // Verificar se ainda não foi adicionado um goleiro ao time e se o jogador é um goleiro não sorteado
                    if (!goleiroAdicionado && jogador.goleiro === 1 && !jogadoresSorteados.includes(jogador)) {
                        // Adicionar o goleiro ao time
                        time.push(jogador);
                        // Marcar o goleiro como sorteado
                        jogadoresSorteados.push(jogador);
                        // Atualizar a flag indicando que um goleiro foi adicionado
                        goleiroAdicionado = true;
                    }
                });

                // Se não foi possível adicionar um goleiro ao time, continuar para o próximo time
                if (!goleiroAdicionado) {
                    continue;
                }

                // Loop para completar o time com jogadores de linha
                for (var j = 0; j < numJogadoresPorTime - 1; j++) {
                    var jogadorAdicionado = false; // Flag para indicar se o jogador foi adicionado ao time
                    // Iterar sobre os jogadores selecionados para formar o time
                    novoArray.forEach(function(jogador) {
                        // Verificar se ainda não foi adicionado um jogador ao time e se o jogador não é um goleiro e não está no time e não foi sorteado
                        if (!jogadorAdicionado && !time.includes(jogador) && !jogadoresSorteados.includes(jogador) && jogador.goleiro === 0) {
                            // Adicionar o jogador ao time
                            time.push(jogador);
                            // Marcar o jogador como sorteado
                            jogadoresSorteados.push(jogador);
                            // Atualizar a flag indicando que um jogador foi adicionado
                            jogadorAdicionado = true;
                        }
                    });
                }

                // Adicionar o time sorteado ao array de times
                times.push(time);
            }

            // Adicionar jogadores não sorteados ao banco
            jogadoresSelecionados.forEach(function(jogador) {
                if (!jogadoresSorteados.includes(jogador)) {
                    banco.push(jogador);
                }
            });

            // Verificar se há pelo menos dois times completos e exibir o resultado do sorteio
            if (verificacaoFinal(times, banco)) {
                exibirResultadoSorteio(times, banco);
                document.querySelector('.numero-jogadores').classList.add('hide');
                document.querySelector('.sorteio').classList.remove('hide');
            } else {
                voltarSorteio();
            }
        });

        // Função para verificar se há pelo menos dois times completos
        function verificacaoFinal(times, banco){
            // Obter o número de jogadores por time selecionado pelo usuário
            var numJogadoresPorTime = parseInt(document.getElementById('select-numero-jogadores').value);
            var numTimesCompletos = 0;

            // Contar quantos times têm pelo menos o número mínimo de jogadores selecionado
            times.forEach(function(time) {
                if (time.length >= numJogadoresPorTime) {
                    numTimesCompletos++;
                }
            });

            // Se houver pelo menos dois times completos, retornar verdadeiro, senão, mostrar mensagem e retornar falso
            if (numTimesCompletos >= 2) {
                return true;
            } else {
                showToastMsg("Não há jogadores suficientes para formar pelo menos dois times completos.");
                return false;
            }
        }

        // Função para exibir o resultado do sorteio
        function exibirResultadoSorteio(times, banco){
            // Obter a div onde o resultado será exibido
            var resultadoSorteioDiv = document.getElementById('resultado-sorteio');
            resultadoSorteioDiv.innerHTML = '';

            // Iterar sobre os times sorteados para exibir suas informações
            times.forEach(function(time, index) {
                var card = document.createElement('div');
                card.classList.add('card');

                var cardHeader = document.createElement('div');
                cardHeader.classList.add('card-content');
                cardHeader.innerHTML = '<span class="card-title">Time ' + (index + 1) + '</span>';

                var cardBody = document.createElement('div');
                cardBody.classList.add('card-content');

                var jogadorList = document.createElement('ul');
                jogadorList.classList.add('collection');

                var totalNivel = 0;

                // Iterar sobre os jogadores do time para exibir seus nomes e níveis
                time.forEach(function(jogador) {
                    var jogadorItem = document.createElement('li');
                    jogadorItem.classList.add('collection-item');
                    var jogadorNome = jogador.nome;

                    if (jogador.goleiro === 1) {
                        jogadorNome += ' (G)';
                    }
                    jogadorItem.textContent = jogadorNome + ' - Nv. ' + jogador.nivel;
                    jogadorList.appendChild(jogadorItem);

                    totalNivel += parseInt(jogador.nivel);
                });

                cardBody.appendChild(jogadorList);
                card.appendChild(cardHeader);
                card.appendChild(cardBody);
                resultadoSorteioDiv.appendChild(card);

                // Exibir o somatório dos níveis dos jogadores do time
                var totalNivelItem = document.createElement('p');
                totalNivelItem.style.marginLeft = '26px';
                totalNivelItem.style.marginTop = '-16px';

                totalNivelItem.textContent = 'Somatório dos níveis: ' + totalNivel;
                card.appendChild(totalNivelItem);
            });

            // Exibir o banco de jogadores não sorteados
            var bancoCard = document.createElement('div');
            bancoCard.classList.add('card');

            var bancoCardHeader = document.createElement('div');
            bancoCardHeader.classList.add('card-content');
            bancoCardHeader.innerHTML = '<span class="card-title">Banco</span>';

            var bancoCardBody = document.createElement('div');
            bancoCardBody.classList.add('card-content');

            var bancoJogadorList = document.createElement('ul');
            bancoJogadorList.classList.add('collection');

            // Iterar sobre os jogadores do banco para exibir seus nomes e níveis
            banco.forEach(function(jogador) {
                var jogadorItem = document.createElement('li');
                jogadorItem.classList.add('collection-item');
                var jogadorNome = jogador.nome;

                if (jogador.goleiro === 1) {
                    jogadorNome += ' (G)';
                }
                jogadorItem.textContent = jogadorNome + ' - Nv. ' + jogador.nivel;
                bancoJogadorList.appendChild(jogadorItem);
            });

            bancoCardBody.appendChild(bancoJogadorList);
            bancoCard.appendChild(bancoCardHeader);
            bancoCard.appendChild(bancoCardBody);
            resultadoSorteioDiv.appendChild(bancoCard);
        }

        // Função para contar o número de goleiros entre os jogadores selecionados
        function contarGoleiros(jogadores) {
            var numGoleiros = 0;

            jogadores.forEach(function(jogador) {
                if (jogador.goleiro === 1) {
                    numGoleiros++;
                }
            });

            return numGoleiros;
        }

        // Função para carregar as opções do select com o número de jogadores por time
        function carregarOpcoesSelect(totalJogadores) {
            var select = document.getElementById('select-numero-jogadores');
            select.innerHTML = '';

            var maxJogadoresPorTime = Math.floor(totalJogadores / 2);
            for (var i = 3; i <= maxJogadoresPorTime; i++) {
                var option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                select.appendChild(option);
            }

            var instance = M.FormSelect.getInstance(select);
            if (!instance) {
                M.FormSelect.init(select);
            } else {
                instance.destroy();
                M.FormSelect.init(select);
            }
        }

        // Função para voltar para a seção inicial
        function voltarInicio() {
            document.querySelector('.iniciar').classList.remove('hide');
            document.querySelector('.confirmar-presenca').classList.add('hide');
            document.querySelector('.numero-jogadores').classList.add('hide');
            document.querySelector('.sorteio').classList.add('hide');
        }

        // Função para voltar para a seção de seleção do número de jogadores por time
        function voltarSorteio() {
            document.querySelector('.sorteio').classList.add('hide');
            document.querySelector('.numero-jogadores').classList.remove('hide');
        }

        // Função para criar a tabela de jogadores
        function criarTabelaJogadores() {
            // Obter os dados dos jogadores do back-end
            var jogadores = @json($records);
            var tabela = document.querySelector('.tabela');

            tabela.innerHTML = '';

            var table = document.createElement('table');
            var thead = document.createElement('thead');
            var tbody = document.createElement('tbody');

            table.classList.add('striped');

            var headerRow = document.createElement('tr');
            var headers = ['Selecionar', 'Nome', 'Nível', 'Goleiro'];

            // Criar os cabeçalhos da tabela
            headers.forEach(function(header) {
                var th = document.createElement('th');
                th.textContent = header;
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Preencher a tabela com os dados dos jogadores
            jogadores.forEach(function(jogador) {
                var row = document.createElement('tr');
                var checkbox = document.createElement('td');
                var nome = document.createElement('td');
                var nivel = document.createElement('td');
                var goleiro = document.createElement('td');

                var input = document.createElement('input');
                input.type = 'checkbox';
                input.style.opacity = 1;
                input.style.pointerEvents = "all";
                checkbox.appendChild(input);

                nome.textContent = jogador.nome;
                nivel.textContent = jogador.nivel;
                goleiro.textContent = jogador.goleiro ? 'Sim' : 'Não';

                row.appendChild(checkbox);
                row.appendChild(nome);
                row.appendChild(nivel);
                row.appendChild(goleiro);

                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            tabela.appendChild(table);
        }

    </script>

@endsection
