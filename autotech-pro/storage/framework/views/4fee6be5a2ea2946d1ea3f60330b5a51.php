

<?php $__env->startSection('title', 'Consulta Tabela FIPE'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Estilização rápida para selects e cards no dark mode */
    .fipe-card {
        background-color: var(--preto-secundario);
        border: 1px solid #2a2a2a;
        color: var(--branco);
    }
    .card-header {
        background-color: rgba(255, 255, 255, 0.03) !important;
        border-bottom: 1px solid #2a2a2a !important;
        color: var(--branco);
    }
    .form-select, .form-control {
        background-color: #1a1a1a;
        border-color: #333;
        color: var(--branco);
    }
    .form-select:focus {
        background-color: #222;
        border-color: var(--vermelho-principal);
        color: var(--branco);
        box-shadow: 0 0 0 0.25rem rgba(196, 0, 0, 0.25);
    }
    .form-select:disabled {
        background-color: #0d0d0d;
        border-color: #222;
        color: #444;
    }
    /* Alert customizado */
    .alert-fipe {
        background-color: rgba(20, 20, 20, 0.8);
        border: 1px border-secondary;
        border-left: 4px solid var(--vermelho-principal);
        color: var(--cinza-medio);
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0">
        <i data-lucide="search" class="text-danger"></i>
        Consulta Tabela FIPE
    </h2>
    <span class="badge bg-dark border border-secondary text-muted">Apenas Carros</span>
</div>

<div class="alert alert-fipe d-flex align-items-start gap-3 mb-4 shadow-sm">
    <i data-lucide="info" class="text-danger mt-1"></i>
    <div>
        <strong>Sobre esta consulta:</strong> A Tabela FIPE mostra o <strong>valor de mercado do veículo completo</strong>. 
        Use este valor como referência para decidir se o custo do reparo é viável perante o valor do bem.
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card fipe-card shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 py-3">
                <i data-lucide="filter" class="size-4 text-muted"></i>
                <strong class="text-uppercase small" style="letter-spacing: 1px;">Selecionar Veículo</strong>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">1. MARCA</label>
                    <select class="form-select form-select-lg" id="select-marca" onchange="carregarModelos()">
                        <option value="">Carregando marcas...</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">2. MODELO</label>
                    <select class="form-select form-select-lg" id="select-modelo" disabled onchange="carregarAnos()">
                        <option value="">Selecione uma marca primeiro</option>
                    </select>
                </div>

                <div class="mb-0">
                    <label class="form-label text-muted small fw-bold">3. ANO / VERSÃO</label>
                    <select class="form-select form-select-lg" id="select-ano" disabled onchange="buscarValor()">
                        <option value="">Selecione um modelo primeiro</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card fipe-card h-100 shadow-sm">
            <div class="card-header d-flex align-items-center gap-2 py-3">
                <i data-lucide="bar-chart-3" class="size-4 text-muted"></i>
                <strong class="text-uppercase small" style="letter-spacing: 1px;">Resultado da Busca</strong>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" id="resultado-fipe">
                <div class="text-center p-5">
                    <i data-lucide="car-front" class="size-12 text-muted opacity-25 mb-3"></i>
                    <p class="text-muted">Aguardando seleção do veículo para consulta...</p>
                </div>
            </div>
        </div>

        <div id="loading" class="text-center mt-3" style="display:none;">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="text-muted mt-2 small">Acessando base de dados FIPE...</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Mantendo suas funções de carregarMarcas, carregarModelos e carregarAnos...
    // [As funções originais devem continuar aqui exatamente como no seu código]

    document.addEventListener('DOMContentLoaded', function() {
        carregarMarcas();
    });

    function carregarMarcas() {
        fetch('<?php echo e(route("fipe.marcas")); ?>')
            .then(res => res.json())
            .then(marcas => {
                var selectMarca = document.getElementById('select-marca');
                selectMarca.innerHTML = '<option value="">Selecione a marca...</option>';
                marcas.forEach(marca => {
                    var option = document.createElement('option');
                    option.value = marca.codigo; option.text = marca.nome;
                    selectMarca.appendChild(option);
                });
            })
            .catch(() => {
                document.getElementById('select-marca').innerHTML = '<option value="">Erro na conexão</option>';
            });
    }

    function carregarModelos() {
        var marcaId = document.getElementById('select-marca').value;
        if (!marcaId) return;
        var selectModelo = document.getElementById('select-modelo');
        var selectAno = document.getElementById('select-ano');
        selectModelo.innerHTML = '<option value="">Carregando...</option>';
        selectModelo.disabled = true;
        selectAno.innerHTML = '<option value="">Aguardando modelo...</option>';
        selectAno.disabled = true;
        document.getElementById('resultado-fipe').innerHTML = '<div class="text-center p-5 text-muted">Selecione o modelo...</div>';

        fetch('<?php echo e(url("/fipe/modelos")); ?>/' + marcaId)
            .then(res => res.json())
            .then(dados => {
                selectModelo.innerHTML = '<option value="">Selecione o modelo...</option>';
                dados.modelos.forEach(m => {
                    var opt = document.createElement('option');
                    opt.value = m.codigo; opt.text = m.nome;
                    selectModelo.appendChild(opt);
                });
                selectModelo.disabled = false;
            });
    }

    function carregarAnos() {
        var marcaId = document.getElementById('select-marca').value;
        var modeloId = document.getElementById('select-modelo').value;
        if (!marcaId || !modeloId) return;
        var selectAno = document.getElementById('select-ano');
        selectAno.innerHTML = '<option value="">Carregando...</option>';
        selectAno.disabled = true;

        fetch('<?php echo e(url("/fipe/anos")); ?>/' + marcaId + '/' + modeloId)
            .then(res => res.json())
            .then(anos => {
                selectAno.innerHTML = '<option value="">Selecione o ano...</option>';
                anos.forEach(a => {
                    var opt = document.createElement('option');
                    opt.value = a.codigo; opt.text = a.nome;
                    selectAno.appendChild(opt);
                });
                selectAno.disabled = false;
            });
    }

    function buscarValor() {
        var marcaId = document.getElementById('select-marca').value;
        var modeloId = document.getElementById('select-modelo').value;
        var ano = document.getElementById('select-ano').value;
        if (!marcaId || !modeloId || !ano) return;

        document.getElementById('loading').style.display = 'block';
        document.getElementById('resultado-fipe').innerHTML = '';

        fetch('<?php echo e(url("/fipe/valor")); ?>/' + marcaId + '/' + modeloId + '/' + ano)
            .then(res => res.json())
            .then(v => {
                document.getElementById('loading').style.display = 'none';
                
                // HTML do Resultado Estilizado para o novo layout
                var html = '<div class="w-100 p-4 text-center">';
                html += '<div class="mb-2 text-danger small fw-bold text-uppercase">' + v.Marca + '</div>';
                html += '<h3 class="mb-3 text-white fw-bold">' + v.Modelo + '</h3>';
                html += '<span class="badge bg-dark border border-secondary mb-4 p-2 px-3">' + v.AnoModelo + ' • ' + v.Combustivel + '</span>';
                html += '<div class="display-4 fw-bold text-white mb-2" style="color: var(--branco)!important;">' + v.Valor + '</div>';
                html += '<p class="text-muted small mb-4">Mês de referência: ' + v.MesReferencia + '</p>';
                
                html += '<div class="row g-2 text-start mt-4 border-top border-secondary pt-4">';
                html += '  <div class="col-6"><div class="p-2 rounded bg-black bg-opacity-25 border border-secondary border-opacity-50 text-center"><small class="text-muted d-block">CÓDIGO FIPE</small><strong class="small">' + v.CodigoFipe + '</strong></div></div>';
                html += '  <div class="col-6"><div class="p-2 rounded bg-black bg-opacity-25 border border-secondary border-opacity-50 text-center"><small class="text-muted d-block">TIPO</small><strong class="small">PASSEIO</strong></div></div>';
                html += '</div>';
                
                html += '<div class="alert mt-4 mb-0 text-start d-flex gap-2" style="background: rgba(196,0,0,0.05); border: 1px dashed rgba(196,0,0,0.3); color: var(--cinza-medio);">';
                html += '  <i data-lucide="lightbulb" class="text-warning size-5"></i>';
                html += '  <small>Dica: O código <strong>' + v.CodigoFipe + '</strong> pode ser usado no cadastro do veículo.</small>';
                html += '</div>';
                html += '</div>';

                document.getElementById('resultado-fipe').innerHTML = html;
                lucide.createIcons(); // Recarrega os ícones gerados via JS
            })
            .catch(() => {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('resultado-fipe').innerHTML = '<div class="alert alert-danger mx-4">Falha ao buscar dados.</div>';
            });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/fipe/index.blade.php ENDPATH**/ ?>