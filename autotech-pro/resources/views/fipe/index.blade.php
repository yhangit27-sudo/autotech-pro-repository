@extends('layouts.app')

@section('title', 'Consulta Tabela FIPE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Consulta Tabela FIPE</h2>
    <small class="text-muted">Apenas veículos do tipo Carro</small>
</div>

<div class="alert alert-info">
    <strong><img src="/icons/info.png" alt="Info" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Sobre esta consulta:</strong> A Tabela FIPE mostra o <strong>valor de mercado do veículo completo</strong>, não de peças individuais. Use este valor como referência para decidir se o custo do reparo é viável.
</div>

<div class="row">
    
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-light"><strong>Selecionar Veículo</strong></div>
            <div class="card-body">

                
                <div class="mb-3">
                    <label class="form-label">1. Marca</label>
                    <select class="form-select" id="select-marca" onchange="carregarModelos()">
                        <option value="">Carregando marcas...</option>
                    </select>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">2. Modelo</label>
                    <select class="form-select" id="select-modelo" disabled onchange="carregarAnos()">
                        <option value="">Selecione uma marca primeiro</option>
                    </select>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">3. Ano</label>
                    <select class="form-select" id="select-ano" disabled onchange="buscarValor()">
                        <option value="">Selecione um modelo primeiro</option>
                    </select>
                </div>

            </div>
        </div>
    </div>

    
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-light"><strong>Resultado</strong></div>
            <div class="card-body" id="resultado-fipe">
                <p class="text-muted text-center mt-3">Selecione marca, modelo e ano para ver o valor FIPE.</p>
            </div>
        </div>

        
        <div id="loading" class="text-center mt-3" style="display:none;">
            <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="text-muted mt-2">Consultando API FIPE...</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    
    
    

    
    document.addEventListener('DOMContentLoaded', function() {
        carregarMarcas();
    });

    
    function carregarMarcas() {
        
        fetch('{{ route("fipe.marcas") }}')
            .then(function(response) {
                
                return response.json();
            })
            .then(function(marcas) {
                
                var selectMarca = document.getElementById('select-marca');
                selectMarca.innerHTML = '<option value="">Selecione a marca...</option>';

                
                marcas.forEach(function(marca) {
                    var option = document.createElement('option');
                    option.value = marca.codigo;   
                    option.text  = marca.nome;     
                    selectMarca.appendChild(option);
                });
            })
            .catch(function(erro) {
                
                document.getElementById('select-marca').innerHTML =
                    '<option value="">Erro ao carregar marcas - verifique a conexão</option>';
                console.error('Erro ao carregar marcas:', erro);
            });
    }

    
    function carregarModelos() {
        var marcaId = document.getElementById('select-marca').value;

        
        if (!marcaId) {
            return;
        }

        
        var selectModelo = document.getElementById('select-modelo');
        var selectAno    = document.getElementById('select-ano');
        selectModelo.innerHTML = '<option value="">Carregando modelos...</option>';
        selectModelo.disabled = true;
        selectAno.innerHTML = '<option value="">Selecione um modelo primeiro</option>';
        selectAno.disabled = true;

        
        document.getElementById('resultado-fipe').innerHTML =
            '<p class="text-muted text-center mt-3">Selecione marca, modelo e ano para ver o valor FIPE.</p>';

        
        fetch('{{ url("/fipe/modelos") }}/' + marcaId)
            .then(function(response) {
                return response.json();
            })
            .then(function(dados) {
                
                var modelos = dados.modelos;
                selectModelo.innerHTML = '<option value="">Selecione o modelo...</option>';

                modelos.forEach(function(modelo) {
                    var option = document.createElement('option');
                    option.value = modelo.codigo;
                    option.text  = modelo.nome;
                    selectModelo.appendChild(option);
                });

                selectModelo.disabled = false; 
            })
            .catch(function(erro) {
                selectModelo.innerHTML = '<option value="">Erro ao carregar modelos</option>';
                console.error('Erro ao carregar modelos:', erro);
            });
    }

    
    function carregarAnos() {
        var marcaId  = document.getElementById('select-marca').value;
        var modeloId = document.getElementById('select-modelo').value;

        if (!marcaId || !modeloId) {
            return;
        }

        var selectAno = document.getElementById('select-ano');
        selectAno.innerHTML = '<option value="">Carregando anos...</option>';
        selectAno.disabled = true;

        document.getElementById('resultado-fipe').innerHTML =
            '<p class="text-muted text-center mt-3">Selecione o ano para ver o valor.</p>';

        fetch('{{ url("/fipe/anos") }}/' + marcaId + '/' + modeloId)
            .then(function(response) {
                return response.json();
            })
            .then(function(anos) {
                selectAno.innerHTML = '<option value="">Selecione o ano...</option>';

                anos.forEach(function(ano) {
                    var option = document.createElement('option');
                    
                    option.value = ano.codigo;
                    option.text  = ano.nome;
                    selectAno.appendChild(option);
                });

                selectAno.disabled = false; 
            })
            .catch(function(erro) {
                selectAno.innerHTML = '<option value="">Erro ao carregar anos</option>';
                console.error('Erro ao carregar anos:', erro);
            });
    }

    
    function buscarValor() {
        var marcaId  = document.getElementById('select-marca').value;
        var modeloId = document.getElementById('select-modelo').value;
        var ano      = document.getElementById('select-ano').value;

        if (!marcaId || !modeloId || !ano) {
            return;
        }

        
        document.getElementById('loading').style.display = 'block';
        document.getElementById('resultado-fipe').innerHTML = '';

        fetch('{{ url("/fipe/valor") }}/' + marcaId + '/' + modeloId + '/' + ano)
            .then(function(response) {
                return response.json();
            })
            .then(function(veiculo) {
                
                document.getElementById('loading').style.display = 'none';

                
                var html = '<div class="text-center">';
                html += '<h3 class="mt-2">' + veiculo.Marca + ' ' + veiculo.Modelo + '</h3>';
                html += '<p class="text-muted">' + veiculo.AnoModelo + ' - ' + veiculo.Combustivel + '</p>';
                html += '<hr>';
                html += '<div class="display-5 fw-bold mb-2">' + veiculo.Valor + '</div>';
                html += '<p class="text-muted">Valor de mercado segundo a Tabela FIPE</p>';
                html += '<hr>';
                html += '<div class="row text-start">';
                html += '<div class="col-6"><strong>Código FIPE:</strong><br>' + veiculo.CodigoFipe + '</div>';
                html += '<div class="col-6"><strong>Mês referência:</strong><br>' + veiculo.MesReferencia + '</div>';
                html += '</div>';
                html += '<hr>';
                html += '<div class="alert alert-light text-start mt-2">';
                html += '<strong><img src="/icons/lightbulb.png" alt="Dica" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Dica:</strong> O código FIPE <strong>' + veiculo.CodigoFipe + '</strong> pode ser copiado ';
                html += 'para o cadastro do veículo no sistema.';
                html += '</div>';
                html += '</div>';

                document.getElementById('resultado-fipe').innerHTML = html;
            })
            .catch(function(erro) {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('resultado-fipe').innerHTML =
                    '<div class="alert alert-danger">Erro ao buscar valor FIPE. Tente novamente.</div>';
                console.error('Erro ao buscar valor:', erro);
            });
    }
</script>
@endsection
