

<?php $__env->startSection('title', 'Nova Peça'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .create-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 12px; }
    .label-small { color: var(--cinza-medio); font-size: 0.7rem; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; }
    .form-control { background: #0a0a0a; border: 1px solid #333; color: white; padding: 0.6rem; transition: 0.3s; }
    .form-control:focus { background: #111; border-color: var(--vermelho-principal); color: white; box-shadow: none; }
    .btn-save { background: var(--vermelho-principal); color: white; font-weight: bold; border: none; }
    .btn-save:hover { background: var(--vermelho-claro); color: white; }
    .input-group-text { background: #1a1a1a; border: 1px solid #333; color: var(--cinza-medio); }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 text-white">
    <h2 class="mb-0 d-flex align-items-center gap-2">
        <i data-lucide="package-plus" class="text-danger"></i> Nova <span class="text-danger">Peça</span>
    </h2>
    <a href="<?php echo e(route('parts.index')); ?>" class="btn btn-outline-light btn-sm">← Voltar</a>
</div>

<div class="card create-card shadow-lg mx-auto" style="max-width: 650px;">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="<?php echo e(route('parts.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label class="label-small mb-2 d-block">Identificação da Peça *</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" placeholder="Ex: Pastilha de freio dianteira" required>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="label-small mb-2 d-block">Preço de Custo *</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" name="cost_price" class="form-control" value="<?php echo e(old('cost_price')); ?>" step="0.01" min="0" required placeholder="0,00">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="label-small mb-2 d-block">Preço de Venda *</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" name="sale_price" class="form-control" value="<?php echo e(old('sale_price')); ?>" step="0.01" min="0" required placeholder="0,00">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="label-small mb-2 d-block">Qtd. Inicial *</label>
                    <input type="number" name="stock_quantity" class="form-control" value="<?php echo e(old('stock_quantity')); ?>" min="0" required placeholder="0">
                </div>
                <div class="col-md-6">
                    <label class="label-small mb-2 d-block">Garantia (Meses)</label>
                    <input type="number" name="manufacturer_warranty_months" class="form-control" value="<?php echo e(old('manufacturer_warranty_months', 3)); ?>" min="0">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-save py-2 shadow-sm">CADASTRAR NO ESTOQUE</button>
                <a href="<?php echo e(route('parts.index')); ?>" class="btn btn-link text-muted text-decoration-none small">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/parts/create.blade.php ENDPATH**/ ?>