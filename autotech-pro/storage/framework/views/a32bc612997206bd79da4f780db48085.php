

<?php $__env->startSection('title', 'Catálogo de Serviços'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .service-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 8px; overflow: hidden; }
    .table-dark { --bs-table-bg: transparent; --bs-table-color: var(--branco); --bs-table-border-color: #2a2a2a; }
    .thead-custom { background: #1a1a1a; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: var(--cinza-medio); }
    .btn-marca { background: var(--vermelho-principal); color: white; border: none; }
    .btn-marca:hover { background: var(--vermelho-claro); color: white; }
    .text-rate { color: #3498db; font-weight: bold; font-family: 'Inter', sans-serif; } /* Azul para serviços/taxas */
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="wrench" class="text-danger"></i> Catálogo de <span class="text-danger">Serviços</span>
    </h2>
    <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
    <a href="<?php echo e(route('services.create')); ?>" class="btn btn-marca d-inline-flex align-items-center gap-2 px-3 shadow-sm">
        <i data-lucide="plus-circle" class="size-5"></i> Novo Serviço
    </a>
    <?php endif; ?>
</div>

<div class="card service-card shadow-lg">
    <div class="card-body p-0 table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="ps-4 py-3 border-0" style="width: 80px;">#</th>
                    <th class="py-3 border-0">Descrição do Serviço</th>
                    <th class="py-3 border-0 text-center ">Valor por Hora</th>
                    <th class="pe-4 py-3 border-0 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4 text-muted small">#<?php echo e($s->id); ?></td>
                    <td>
                        <div class="text-white fw-bold"><?php echo e($s->description); ?></div>
                    </td>
                    <td class="text-center">
                        <span class="text-lime-500 drop-shadow-lime-400">
                            R$ <?php echo e(number_format($s->hourly_rate, 2, ',', '.')); ?>

                        </span>
                        <small class="text-muted">/h</small>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
                            <a href="<?php echo e(route('services.edit', $s->id)); ?>" class="btn btn-sm btn-outline-light border-0" title="Editar">
                                <i data-lucide="edit-3" class="size-4"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if(session('user_role') === 'manager'): ?>
                            <form method="POST" action="<?php echo e(route('services.destroy', $s->id)); ?>" class="d-inline" onsubmit="return confirm('Remover este serviço do catálogo?')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Excluir">
                                    <i data-lucide="trash-2" class="size-4"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">
                        <i data-lucide="clipboard-x" class="size-10 opacity-25 mb-2"></i>
                        <p>O catálogo de serviços está vazio.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/services-catalog/index.blade.php ENDPATH**/ ?>