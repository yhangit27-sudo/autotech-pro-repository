

<?php $__env->startSection('title', 'Peças / Estoque'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .stock-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 8px; overflow: hidden; }
    .table-dark { --bs-table-bg: transparent; --bs-table-color: var(--branco); --bs-table-border-color: #2a2a2a; }
    .thead-custom { background: #1a1a1a; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: var(--cinza-medio); }
    .btn-marca { background: var(--vermelho-principal); color: white; border: none; }
    .btn-marca:hover { background: var(--vermelho-claro); color: white; }
    .text-money { color: #2ecc71; font-weight: bold; } /* Verde para dinheiro/venda */
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="package" class="text-danger"></i> Peças / <span class="text-danger">Estoque</span>
    </h2>
    <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
    <a href="<?php echo e(route('parts.create')); ?>" class="btn btn-marca d-inline-flex align-items-center gap-2 px-3">
        <i data-lucide="plus-circle" class="size-5"></i> Nova Peça
    </a>
    <?php endif; ?>
</div>

<div class="card stock-card shadow-lg">
    <div class="card-body p-0 table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="ps-4 py-3 border-0">Peça</th>
                    <th class="py-3 border-0 text-center">Custo</th>
                    <th class="py-3 border-0 text-center">Venda</th>
                    <th class="py-3 border-0 text-center">Margem</th>
                    <th class="py-3 border-0 text-center">Estoque</th>
                    <th class="py-3 border-0 text-center">Garantia</th>
                    <th class="pe-4 py-3 border-0 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4">
                        <div class="text-white fw-bold"><?php echo e($part->name); ?></div>
                        <small class="text-muted">ID: #<?php echo e($part->id); ?></small>
                    </td>
                    <td class="text-center text-muted small">
                        R$ <?php echo e(number_format($part->cost_price, 2, ',', '.')); ?>

                    </td>
                    <td class="text-center text-money">
                        R$ <?php echo e(number_format($part->sale_price, 2, ',', '.')); ?>

                    </td>
                    <td class="text-center">
                        <?php
                            $margem = (($part->sale_price - $part->cost_price) / $part->cost_price) * 100;
                        ?>
                        <span class="badge bg-dark border border-secondary text-white-50">
                            <?php echo e(number_format($margem, 0)); ?>%
                        </span>
                    </td>
                    <td class="text-center">
                        <?php if($part->stock_quantity < 5): ?>
                            <span class="badge bg-danger shadow-sm px-3" title="Estoque Crítico"><?php echo e($part->stock_quantity); ?> un</span>
                        <?php elseif($part->stock_quantity < 10): ?>
                            <span class="badge bg-warning text-dark px-3"><?php echo e($part->stock_quantity); ?> un</span>
                        <?php else: ?>
                            <span class="badge bg-secondary px-3"><?php echo e($part->stock_quantity); ?> un</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center small text-muted">
                        <i data-lucide="shield" class="size-3 me-1"></i><?php echo e($part->manufacturer_warranty_months); ?> meses
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
                            <a href="<?php echo e(route('parts.edit', $part->id)); ?>" class="btn btn-sm btn-outline-light border-0">
                                <i data-lucide="edit-2" class="size-4"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if(session('user_role') === 'manager'): ?>
                            <form method="POST" action="<?php echo e(route('parts.destroy', $part->id)); ?>" class="d-inline" onsubmit="return confirm('Remover esta peça do estoque?')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                    <i data-lucide="trash-2" class="size-4"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i data-lucide="package-x" class="size-10 opacity-25 mb-2"></i>
                        <p>Nenhuma peça em estoque.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/parts/index.blade.php ENDPATH**/ ?>