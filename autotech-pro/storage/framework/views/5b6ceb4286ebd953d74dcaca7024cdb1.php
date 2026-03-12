

<?php $__env->startSection('title', 'Editar Serviço'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .edit-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 12px; }
    .label-small { color: var(--cinza-medio); font-size: 0.7rem; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; }
    .form-control { background: #0a0a0a; border: 1px solid #333; color: white; padding: 0.7rem; transition: 0.3s; }
    .form-control:focus { background: #111; border-color: var(--vermelho-principal); color: white; box-shadow: none; }
    .btn-update { background: var(--vermelho-principal); color: white; font-weight: bold; border: none; text-transform: uppercase; letter-spacing: 1px; }
    .btn-update:hover { background: var(--vermelho-claro); color: white; transform: translateY(-1px); }
    .input-group-text { background: #1a1a1a; border: 1px solid #333; color: #3498db; font-weight: bold; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 text-white">
    <h2 class="mb-0 d-flex align-items-center gap-2">
        <i data-lucide="edit-3" class="text-danger"></i> Editar <span class="text-danger">Serviço</span>
    </h2>
    <a href="<?php echo e(route('services.index')); ?>" class="btn btn-outline-light btn-sm">← Voltar</a>
</div>

<div class="card edit-card shadow-lg mx-auto" style="max-width: 550px;">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="<?php echo e(route('services.update', $service->id)); ?>">
            <?php echo csrf_field(); ?>
            

            <div class="mb-4">
                <label class="label-small mb-2 d-block">Descrição do Serviço</label>
                <input type="text" name="description" class="form-control" 
                       value="<?php echo e(old('description', $service->description)); ?>" required>
            </div>

            <div class="mb-4">
                <label class="label-small mb-2 d-block">Valor por Hora (Mão de Obra)</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" name="hourly_rate" class="form-control" 
                           value="<?php echo e(old('hourly_rate', $service->hourly_rate)); ?>" step="0.01" min="0" required>
                    <span class="input-group-text text-muted font-monospace" style="font-size: 0.8rem;">/h</span>
                </div>
            </div>

            <hr class="my-4 opacity-25">

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-update py-3 shadow-sm">
                    <i data-lucide="save" class="size-4 me-2"></i> Atualizar Serviço
                </button>
                <a href="<?php echo e(route('services.index')); ?>" class="btn btn-link text-muted text-decoration-none small">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/services-catalog/edit.blade.php ENDPATH**/ ?>