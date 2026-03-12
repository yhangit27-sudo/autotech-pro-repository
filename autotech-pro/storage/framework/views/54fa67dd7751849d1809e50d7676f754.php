

<?php $__env->startSection('title', 'Editar Veículo'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .edit-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 12px; }
    .form-label { color: var(--cinza-medio); font-size: 0.75rem; text-transform: uppercase; font-weight: bold; }
    .form-control, .form-select { background: #0a0a0a; border: 1px solid #333; color: white; padding: 0.6rem; }
    .form-control:focus, .form-select:focus { background: #111; border-color: var(--vermelho-principal); color: white; box-shadow: none; }
    .btn-update { background: var(--vermelho-principal); color: white; font-weight: bold; border: none; transition: 0.3s; }
    .btn-update:hover { background: var(--vermelho-claro); color: white; transform: translateY(-1px); }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-white mb-0 d-flex align-items-center gap-2">
        <i data-lucide="edit-3" class="text-danger"></i> Editar <span class="text-danger">Veículo</span>
    </h2>
    <a href="<?php echo e(route('vehicles.index')); ?>" class="btn btn-outline-light btn-sm">← Voltar</a>
</div>

<div class="card edit-card shadow-lg mx-auto" style="max-width: 650px;">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="<?php echo e(route('vehicles.update', $vehicle->id)); ?>">
            <?php echo csrf_field(); ?>
            

            <div class="mb-4">
                <label class="form-label">Proprietário (Cliente)</label>
                <select class="form-select" name="customer_id" required>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>" <?php echo e($vehicle->customer_id == $c->id ? 'selected' : ''); ?>>
                        <?php echo e($c->full_name); ?> — <?php echo e($c->tax_id); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Placa</label>
                    <input type="text" name="license_plate" class="form-control text-uppercase font-monospace" 
                           value="<?php echo e(old('license_plate', $vehicle->license_plate)); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Código FIPE</label>
                    <input type="text" name="fipe_code" class="form-control" 
                           value="<?php echo e(old('fipe_code', $vehicle->fipe_code)); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Marca</label>
                    <input type="text" name="brand" class="form-control" 
                           value="<?php echo e(old('brand', $vehicle->brand)); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="model" class="form-control" 
                           value="<?php echo e(old('model', $vehicle->model)); ?>">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-update py-2">SALVAR ALTERAÇÕES</button>
                <a href="<?php echo e(route('vehicles.index')); ?>" class="btn btn-link text-muted text-decoration-none small">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/vehicles/edit.blade.php ENDPATH**/ ?>