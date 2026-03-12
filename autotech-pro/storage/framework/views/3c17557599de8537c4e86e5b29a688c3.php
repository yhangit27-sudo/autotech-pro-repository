

<?php $__env->startSection('title', 'OS #'.$order->id); ?>

<?php $__env->startSection('content'); ?>
<style>
    .os-card {
        background-color: var(--preto-secundario);
        border: 1px solid #2a2a2a;
        color: var(--branco);
        border-radius: 8px;
    }
    .os-card .card-header {
        background-color: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid #2a2a2a;
        color: var(--branco);
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }
    .label-muted {
        color: var(--cinza-medio);
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: bold;
        display: block;
        margin-bottom: 2px;
    }
    .info-value {
        color: var(--branco);
        font-size: 1rem;
    }
    .form-select, .form-control {
        background-color: #1a1a1a;
        border-color: #333;
        color: var(--branco);
    }
    .form-select:focus, .form-control:focus {
        background-color: #222;
        border-color: var(--vermelho-principal);
        color: var(--branco);
        box-shadow: 0 0 0 0.25rem rgba(196, 0, 0, 0.25);
    }
    .diagnosis-box {
        background-color: rgba(0,0,0,0.2);
        border: 1px solid #333;
        border-radius: 6px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="file-text" class="text-danger"></i>
        Ordem de Serviço <span class="text-danger">#<?php echo e($order->id); ?></span>
    </h2>
    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
        <i data-lucide="arrow-left" class="size-4"></i> Voltar
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        
        <div class="card os-card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <span class="d-flex align-items-center gap-2">
                    <i data-lucide="info" class="size-4"></i> Informações Gerais
                </span>
                <?php switch($order->status):
                    case ('received'): ?> <span class="badge bg-secondary">Recebido</span> <?php break; ?>
                    <?php case ('diagnostic'): ?> <span class="badge bg-primary">Diagnóstico</span> <?php break; ?>
                    <?php case ('awaiting_approval'): ?> <span class="badge bg-warning text-dark">Aguardando Aprovação</span> <?php break; ?>
                    <?php case ('in_repair'): ?> <span class="badge bg-info text-dark">Em Reparo</span> <?php break; ?>
                    <?php case ('ready'): ?> <span class="badge bg-success">Pronto para Entrega</span> <?php break; ?>
                    <?php case ('delivered'): ?> <span class="badge bg-dark border border-secondary text-muted">Entregue</span> <?php break; ?>
                <?php endswitch; ?>
            </div>
            <div class="card-body p-4">
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <span class="label-muted">Veículo</span>
                        <div class="info-value fw-bold"><?php echo e($order->license_plate); ?></div>
                        <div class="text-muted small"><?php echo e($order->brand); ?> <?php echo e($order->model); ?></div>
                    </div>
                    <div class="col-md-4">
                        <span class="label-muted">Cliente</span>
                        <div class="info-value"><?php echo e($order->customer_name); ?></div>
                    </div>
                    <div class="col-md-4">
                        <span class="label-muted">Referência FIPE</span>
                        <div class="info-value text-muted"><?php echo e($order->fipe_code ?? '---'); ?></div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <span class="label-muted">Atendente</span>
                        <div class="info-value"><?php echo e($order->attendant_name); ?></div>
                    </div>
                    <div class="col-md-4">
                        <span class="label-muted">Mecânico Responsável</span>
                        <div class="info-value <?php echo e(!$order->mechanic_name ? 'text-warning small' : ''); ?>">
                            <?php echo e($order->mechanic_name ?? 'Pendente de atribuição'); ?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <span class="label-muted">Data de Abertura</span>
                        <div class="info-value small"><?php echo e(date('d/m/Y H:i', strtotime($order->opened_at))); ?></div>
                    </div>
                </div>

                <?php if($order->labor_warranty_expiry): ?>
                <hr class="my-4 border-secondary opacity-25">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <span class="label-muted">Garantia de Mão de Obra</span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="info-value"><?php echo e(date('d/m/Y', strtotime($order->labor_warranty_expiry))); ?></span>
                            <?php if(strtotime($order->labor_warranty_expiry) < time()): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 small">Vencida</span>
                            <?php else: ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small">Válida</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="label-muted">Status de Aprovação</span>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <?php if($order->customer_approval): ?>
                                <i data-lucide="check-circle-2" class="text-success size-5"></i>
                                <span class="text-success fw-bold">Aprovado pelo Cliente</span>
                            <?php else: ?>
                                <i data-lucide="clock" class="text-warning size-5"></i>
                                <span class="text-warning fw-bold">Aguardando Resposta</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card os-card mb-4 shadow-sm border-start-danger">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <span class="d-flex align-items-center gap-2">
                    <i data-lucide="stethoscope" class="size-4"></i> Sintomas e Diagnóstico
                </span>
                <?php if(in_array(session('user_role'), ['mechanic', 'manager', 'attendant'])): ?>
                <a href="<?php echo e(route('orders.edit', $order->id)); ?>" class="btn btn-sm btn-link text-danger text-decoration-none p-0 fw-bold">
                    <i data-lucide="edit-3" class="size-4"></i> EDITAR
                </a>
                <?php endif; ?>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="label-muted">Sintomas relatados pelo cliente:</label>
                    <div class="p-3 diagnosis-box italic text-muted">
                        "<?php echo e($order->customer_symptoms ?? 'Nenhum sintoma detalhado.'); ?>"
                    </div>
                </div>
                <div>
                    <label class="label-muted">Parecer Técnico / Diagnóstico:</label>
                    <div class="p-3 diagnosis-box border-danger border-opacity-25">
                        <?php echo e($order->mechanic_diagnosis ?? 'O mecânico ainda não registrou o diagnóstico técnico.'); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card os-card h-100 shadow-sm">
                    <div class="card-header py-3 d-flex align-items-center gap-2">
                        <i data-lucide="camera" class="size-4"></i> Fotos de Entrada
                    </div>
                    <div class="card-body">
                        <?php if(count($entryPhotos) > 0): ?>
                        <div class="row g-2">
                            <?php $__currentLoopData = $entryPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-4">
                                <div class="position-relative group">
                                    <img src="<?php echo e(asset($photo->photo_url)); ?>" class="img-fluid rounded border border-secondary" style="height: 80px; width: 100%; object-fit: cover;">
                                    <div class="text-center small text-muted mt-1" style="font-size: 0.6rem;"><?php echo e(strtoupper($photo->position)); ?></div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4 text-muted border border-secondary border-dashed rounded">
                            <i data-lucide="image-off" class="size-8 opacity-25 mb-2"></i>
                            <p class="small mb-0">Sem fotos de entrada.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card os-card h-100 shadow-sm">
                    <div class="card-header py-3 d-flex align-items-center gap-2">
                        <i data-lucide="log-out" class="size-4 text-success"></i> Fotos de Saída
                    </div>
                    <div class="card-body">
                        <?php if(count($exitPhotos) > 0): ?>
                        <div class="row g-2">
                            <?php $__currentLoopData = $exitPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-4">
                                <img src="<?php echo e(asset($photo->photo_url)); ?>" class="img-fluid rounded border border-secondary" style="height: 80px; width: 100%; object-fit: cover;">
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4 text-muted border border-secondary border-dashed rounded">
                            <p class="small mb-0">Aguardando conclusão do reparo.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        
        <?php if(in_array(session('user_role'), ['attendant', 'mechanic', 'manager'])): ?>
        <div class="card os-card mb-4 shadow-sm border-top border-danger border-4">
            <div class="card-header py-3">Anexar Nova Foto</div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('orders.photos', $order->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="label-muted">Tipo de Registro</label>
                        <select class="form-select form-select-sm" name="entry_exit" required>
                            <option value="entry">Check-in (Entrada)</option>
                            <option value="exit">Check-out (Saída)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="label-muted">Posição</label>
                        <select class="form-select form-select-sm" name="position" required>
                            <option value="front">Frontal</option>
                            <option value="rear">Traseira</option>
                            <option value="left_side">Lateral Esquerda</option>
                            <option value="right_side">Lateral Direita</option>
                            <option value="interior">Interior / Painel</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="label-muted">Arquivo</label>
                        <input type="file" class="form-control form-control-sm" name="photo" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold">
                        SUBIR ARQUIVO
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <?php if(in_array(session('user_role'), ['attendant', 'mechanic', 'manager'])): ?>
        <div class="card os-card mb-4 shadow-sm">
            <div class="card-header py-3">Gestão de Progresso</div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('orders.status', $order->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="label-muted">Alterar para:</label>
                        <select class="form-select form-select-sm" name="status" required>
                            <option value="received" <?php echo e($order->status == 'received' ? 'selected' : ''); ?>>Recebido</option>
                            <option value="diagnostic" <?php echo e($order->status == 'diagnostic' ? 'selected' : ''); ?>>Diagnóstico</option>
                            <option value="awaiting_approval" <?php echo e($order->status == 'awaiting_approval' ? 'selected' : ''); ?>>Aguardando Aprovação</option>
                            <option value="in_repair" <?php echo e($order->status == 'in_repair' ? 'selected' : ''); ?>>Em Reparo (Aprovado)</option>
                            <option value="ready" <?php echo e($order->status == 'ready' ? 'selected' : ''); ?>>Pronto para Entrega</option>
                            <option value="delivered" <?php echo e($order->status == 'delivered' ? 'selected' : ''); ?>>Entregue (Gera Garantia)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-bold mb-3">ATUALIZAR STATUS</button>
                </form>
                <div class="d-flex gap-2 p-2 rounded bg-black bg-opacity-25 border border-secondary border-opacity-25">
                    <i data-lucide="shield-check" class="text-info size-8"></i>
                    <small class="text-muted" style="font-size: 0.7rem;">
                        <strong>Nota:</strong> Ao marcar como 'Entregue', o sistema ativa o selo de garantia de 90 dias automaticamente.
                    </small>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(in_array(session('user_role'), ['attendant', 'manager'])): ?>
        <div class="card os-card shadow-sm">
            <div class="card-header py-3">Equipe Técnica</div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('orders.update', $order->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="label-muted">Mecânico Responsável</label>
                        <select class="form-select form-select-sm" name="mechanic_id">
                            <option value="">Aguardando seleção...</option>
                            <?php $__currentLoopData = $mechanics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mechanic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($mechanic->id); ?>" <?php echo e($order->mechanic_id == $mechanic->id ? 'selected' : ''); ?>>
                                    <?php echo e($mechanic->full_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">DESIGNAR TÉCNICO</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/service-orders/show.blade.php ENDPATH**/ ?>