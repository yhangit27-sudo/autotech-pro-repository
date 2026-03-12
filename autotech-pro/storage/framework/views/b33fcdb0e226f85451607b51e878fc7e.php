

<?php $__env->startSection('title', 'Nova Ordem de Serviço'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .create-card {
        background-color: var(--preto-secundario);
        border: 1px solid #2a2a2a;
        color: var(--branco);
        border-radius: 12px;
    }
    /* Estilização dos Inputs e Selects */
    .form-label {
        color: var(--cinza-medio);
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        background-color: #0a0a0a;
        border: 1px solid #333;
        color: white;
        padding: 0.75rem;
        transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        background-color: #111;
        border-color: var(--vermelho-principal);
        box-shadow: 0 0 0 0.25rem rgba(196, 0, 0, 0.15);
        color: white;
    }
    .form-control::placeholder {
        color: #444;
    }
    /* Texto de ajuda abaixo dos campos */
    .form-text {
        color: #666;
        font-size: 0.75rem;
    }
    .form-text a {
        color: var(--vermelho-claro);
        text-decoration: none;
        font-weight: bold;
    }
    .form-text a:hover {
        text-decoration: underline;
    }
    /* Alerta customizado */
    .alert-premium {
        background-color: rgba(196, 0, 0, 0.05);
        border: 1px solid rgba(196, 0, 0, 0.2);
        color: var(--branco);
        border-radius: 8px;
    }
    .btn-submit {
        background-color: var(--vermelho-principal);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        font-weight: bold;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        background-color: var(--vermelho-claro);
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="plus-circle" class="text-danger"></i>
        Abrir Nova <span class="text-danger">OS</span>
    </h2>
    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
        <i data-lucide="arrow-left" class="size-4"></i> Voltar para Lista
    </a>
</div>

<div class="card create-card shadow-lg mx-auto" style="max-width: 800px;">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="<?php echo e(route('orders.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label for="vehicle_id" class="form-label">
                    <i data-lucide="car" class="size-3 me-1"></i> Veículo <span class="text-danger">*</span>
                </label>
                <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                    <option value="" class="text-muted">Selecione o veículo pela placa...</option>
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($vehicle->id); ?>" <?php echo e(old('vehicle_id') == $vehicle->id ? 'selected' : ''); ?>>
                        <?php echo e($vehicle->license_plate); ?> — <?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?> (<?php echo e($vehicle->customer_name); ?>)
                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div class="form-text d-flex align-items-center gap-1 mt-2">
                    <i data-lucide="help-circle" class="size-3"></i>
                    Não encontrou o veículo? <a href="<?php echo e(route('vehicles.create')); ?>" target="_blank">Cadastrar novo agora</a>
                </div>
            </div>

            <div class="mb-4">
                <label for="mechanic_id" class="form-label">
                    <i data-lucide="wrench" class="size-3 me-1"></i> Mecânico Responsável
                </label>
                <select class="form-select" id="mechanic_id" name="mechanic_id">
                    <option value="">Aguardando atribuição (opcional agora)</option>
                    <?php $__currentLoopData = $mechanics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mechanic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($mechanic->id); ?>" <?php echo e(old('mechanic_id') == $mechanic->id ? 'selected' : ''); ?>>
                        <?php echo e($mechanic->full_name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="customer_symptoms" class="form-label">
                    <i data-lucide="message-square" class="size-3 me-1"></i> Sintomas Relatados <span class="text-danger">*</span>
                </label>
                <textarea class="form-control" id="customer_symptoms" name="customer_symptoms" 
                          rows="5" required 
                          placeholder="Ex: Barulho metálico na suspensão dianteira ao passar em lombadas, luz da injeção piscando..."><?php echo e(old('customer_symptoms')); ?></textarea>
                <div class="form-text text-warning opacity-75 mt-2">
                    <i data-lucide="shield-alert" class="size-3"></i>
                    Este campo é vital para a segurança jurídica da oficina.
                </div>
            </div>

            <div class="alert alert-premium d-flex align-items-start gap-3 mb-5">
                <i data-lucide="camera" class="text-danger mt-1"></i>
                <div>
                    <strong class="d-block mb-1">Nota sobre a RN004:</strong>
                    <span class="small opacity-75">Após salvar esta Ordem de Serviço, o sistema solicitará obrigatoriamente as 4 fotos de entrada para conformidade técnica.</span>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-3">
                <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center gap-2 shadow-sm">
                    <i data-lucide="save" class="size-5"></i>
                    GERAR ORDEM DE SERVIÇO
                </button>
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                    Descartar
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/service-orders/create.blade.php ENDPATH**/ ?>