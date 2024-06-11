@extends('app.layouts.basic')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('conteudo')
    <div class="dashboard-container">
        <div class="titulo-pagina">
            <h3 class="title-h3">Bem-vindo(a) ao seu painel de controle!</h3>
        </div>

        <div class="dashboard-content">
            <a href="{{ route('app.cliente') }}" class="dashboard-card dashboard-card-customers">
                <i class="fas fa-users fa-2x"></i>
                <h3>Clientes Cadastrados</h3>
                <p class="total-clientes">{{ $total_clientes }}</p>
            </a>

            <a href="{{ route('app.pedido') }}" class="dashboard-card dashboard-card-orders">
                <i class="fas fa-shopping-cart fa-2x"></i>
                <h3>Pedidos Realizados</h3>
                <p class="total-pedidos">{{ $total_pedidos }}</p>
            </a>

            <a href="{{ route('app.produto') }}" class="dashboard-card dashboard-card-products">
                <i class="fas fa-box-open fa-2x"></i>
                <h3>Produtos Cadastrados</h3>
                <p class="total-produtos">{{ $total_produtos }}</p>
            </a>

            <a href="{{ route('app.fornecedor') }}" class="dashboard-card dashboard-card-suppliers">
                <i class="fas fa-truck fa-2x"></i>
                <h3>Fornecedores Cadastrados</h3>
                <p class="total-fornecedores">{{ $total_fornecedores }}</p>
            </a>
        </div>

        <!-- Adicione uma seção de gráficos -->
        <div class="dashboard-charts">
            <h3 class="charts-title">Visão Geral dos Dados</h3>
            <canvas id="chart-container"></canvas>
        </div>
    </div>

    @include('app.layouts._partials.footer')
@endsection

@push('scripts')
    <!-- Adicione um link ao CDN de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Código JavaScript para gerar gráficos
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chart-container').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Clientes', 'Pedidos', 'Produtos', 'Fornecedores'],
                    datasets: [{
                        label: 'Totais',
                        data: [{{ $total_clientes }}, {{ $total_pedidos }}, {{ $total_produtos }}, {{ $total_fornecedores }}],
                        backgroundColor: [
                            '#fabe2c',
                            '#2ecc71',
                            '#e74c3c',
                            '#3498db'
                        ],
                        borderColor: [
                            '#f39c12',
                            '#27ae60',
                            '#c0392b',
                            '#2980b9'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
