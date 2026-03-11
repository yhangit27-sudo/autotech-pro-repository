@extends('layouts.app')

@section('title', 'OS #{{ $order->id }}')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Ordem de Serviço #{{ $order->id }}</h2>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">← Voltar</a>
</div>

<div class="row">

    
    <div class="col-md-8">

        
        <div class="card mb-3">
            <div class="card-header bg-light d-flex justify-content-between">
                <strong>Dados da Ordem de Serviço</strong>
                @switch($order->status)
                    @case('received') <span class="badge bg-secondary fs-6">Recebido</span> @break
                    @case('diagnostic') <span class="badge bg-primary fs-6">Diagnóstico</span> @break
                    @case('awaiting_approval') <span class="badge bg-warning text-dark fs-6">Aguardando Aprovação</span> @break
                    @case('in_repair') <span class="badge bg-warning text-dark fs-6">Em Reparo</span> @break
                    @case('ready') <span class="badge bg-success fs-6">Pronto para Entrega</span> @break
                    @case('delivered') <span class="badge bg-dark fs-6">Entregue</span> @break
                @endswitch
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Veículo:</strong><br>{{ $order->license_plate }} - {{ $order->brand }} {{ $order->model }}</div>
                    <div class="col-md-4"><strong>Cliente:</strong><br>{{ $order->customer_name }}</div>
                    <div class="col-md-4"><strong>Código FIPE:</strong><br>{{ $order->fipe_code ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Atendente:</strong><br>{{ $order->attendant_name }}</div>
                    <div class="col-md-4"><strong>Mecânico:</strong><br>{{ $order->mechanic_name ?? 'Não atribuído' }}</div>
                    <div class="col-md-4"><strong>Abertura:</strong><br>{{ date('d/m/Y H:i', strtotime($order->opened_at)) }}</div>
                </div>
                @if($order->labor_warranty_expiry)
                <div class="row">
                    <div class="col-md-4">
                        <strong>Garantia Mão de Obra:</strong><br>
                        {{ date('d/m/Y', strtotime($order->labor_warranty_expiry)) }}
                        @if(strtotime($order->labor_warranty_expiry) < time())
                            <span class="badge bg-secondary">Vencida</span>
                        @else
                            <span class="badge bg-success">Válida</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <strong>Aprovação do Cliente:</strong><br>
                        {{ $order->customer_approval ? '<img src="/icons/check.png" alt="Aprovado" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Aprovado' : '<img src="/icons/clock.png" alt="Pendente" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Pendente' }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        
        <div class="card mb-3">
            <div class="card-header bg-light"><strong>Sintomas e Diagnóstico</strong></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Sintomas relatados pelo cliente:</label>
                    <p class="border rounded p-2 bg-light">{{ $order->customer_symptoms ?? 'Não informado.' }}</p>
                </div>
                <div>
                    <label class="form-label text-muted">Diagnóstico do mecânico:</label>
                    <p class="border rounded p-2 bg-light">{{ $order->mechanic_diagnosis ?? 'Diagnóstico ainda não registrado.' }}</p>
                </div>

                
                @if(in_array(session('user_role'), ['mechanic', 'manager', 'attendant']))
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-outline-secondary"><img src="/icons/pencil.png" alt="Editar" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Editar Diagnóstico</a>
                @endif
            </div>
        </div>

        
        <div class="card mb-3">
            <div class="card-header bg-light"><strong><img src="/icons/camera.png" alt="Foto" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Fotos de Entrada</strong> (obrigatório - RN004)</div>
            <div class="card-body">
                @if(count($entryPhotos) > 0)
                <div class="row">
                    @foreach($entryPhotos as $photo)
                    <div class="col-md-3 mb-2">
                        <img src="{{ asset($photo->photo_url) }}" class="img-thumbnail" style="width:100%; height:120px; object-fit:cover;">
                        <small class="text-muted d-block text-center">
                            @switch($photo->position)
                                @case('front') Frontal @break
                                @case('rear') Traseira @break
                                @case('left_side') Lateral Esq. @break
                                @case('right_side') Lateral Dir. @break
                                @case('interior') Interior @break
                            @endswitch
                        </small>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-warning mb-0">
                    <img src="/icons/alert.png" alt="Atenção" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Nenhuma foto de entrada cadastrada. Adicione as fotos abaixo.
                </div>
                @endif
            </div>
        </div>

        
        <div class="card mb-3">
            <div class="card-header bg-light"><strong><img src="/icons/camera.png" alt="Foto" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Fotos de Saída</strong></div>
            <div class="card-body">
                @if(count($exitPhotos) > 0)
                <div class="row">
                    @foreach($exitPhotos as $photo)
                    <div class="col-md-3 mb-2">
                        <img src="{{ asset($photo->photo_url) }}" class="img-thumbnail" style="width:100%; height:120px; object-fit:cover;">
                        <small class="text-muted d-block text-center">
                            @switch($photo->position)
                                @case('front') Frontal @break
                                @case('rear') Traseira @break
                                @case('left_side') Lateral Esq. @break
                                @case('right_side') Lateral Dir. @break
                                @case('interior') Interior @break
                            @endswitch
                        </small>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted mb-0">Nenhuma foto de saída ainda.</p>
                @endif
            </div>
        </div>

    </div>

    
    <div class="col-md-4">

        
        @if(in_array(session('user_role'), ['attendant', 'mechanic', 'manager']))
        <div class="card mb-3">
            <div class="card-header bg-light"><strong>Adicionar Foto</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.photos', $order->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-2">
                        <label class="form-label">Tipo</label>
                        <select class="form-select form-select-sm" name="entry_exit" required>
                            <option value="entry">Entrada</option>
                            <option value="exit">Saída</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Posição</label>
                        <select class="form-select form-select-sm" name="position" required>
                            <option value="front">Frontal</option>
                            <option value="rear">Traseira</option>
                            <option value="left_side">Lateral Esquerda</option>
                            <option value="right_side">Lateral Direita</option>
                            <option value="interior">Interior</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Arquivo</label>
                        <input type="file" class="form-control form-control-sm" name="photo" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-sm btn-dark w-100">Enviar Foto</button>
                </form>
            </div>
        </div>
        @endif

        
        @if(in_array(session('user_role'), ['attendant', 'mechanic', 'manager']))
        <div class="card mb-3">
            <div class="card-header bg-light"><strong>Alterar Status</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.status', $order->id) }}">
                    @csrf

                    <div class="mb-2">
                        <select class="form-select form-select-sm" name="status" required>
                            <option value="">Selecione o novo status...</option>
                            <option value="received" {{ $order->status == 'received' ? 'selected' : '' }}>Recebido</option>
                            <option value="diagnostic" {{ $order->status == 'diagnostic' ? 'selected' : '' }}>Diagnóstico</option>
                            <option value="awaiting_approval" {{ $order->status == 'awaiting_approval' ? 'selected' : '' }}>Aguardando Aprovação</option>
                            <option value="in_repair" {{ $order->status == 'in_repair' ? 'selected' : '' }}>Em Reparo (= Cliente Aprovou)</option>
                            <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Pronto para Entrega</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Entregue (gera garantia 90 dias)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-sm btn-dark w-100">Atualizar Status</button>
                </form>
                <div class="mt-2">
                    <small class="text-muted">
                        <img src="/icons/info.png" alt="Info" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Ao marcar como "Entregue", o sistema calcula automaticamente a garantia de 90 dias.
                    </small>
                </div>
            </div>
        </div>
        @endif

        
        @if(in_array(session('user_role'), ['attendant', 'manager']))
        <div class="card mb-3">
            <div class="card-header bg-light"><strong>Mecânico Responsável</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.update', $order->id) }}">
                    @csrf
                    <div class="mb-2">
                        <select class="form-select form-select-sm" name="mechanic_id">
                            <option value="">Sem mecânico</option>
                            @foreach($mechanics as $mechanic)
                            <option value="{{ $mechanic->id }}" {{ $order->mechanic_id == $mechanic->id ? 'selected' : '' }}>
                                {{ $mechanic->full_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-dark w-100">Atribuir Mecânico</button>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
