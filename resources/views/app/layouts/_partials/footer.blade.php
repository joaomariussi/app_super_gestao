<footer class="rodape">
    <div class="redes-sociais">
        <h2>Redes sociais</h2>
        <div class="redes-img">
            <a class="facebook" href="https://www.facebook.com/" target="_blank">
                <img src="{{ asset('img/facebook.png') }}" alt="Facebook">
            </a>
            <a class="linkedin" href="https://www.linkedin.com/" target="_blank">
                <img src="{{ asset('img/linkedin.png') }}" alt="LinkedIn">
            </a>
            <a class="youtube" href="https://www.youtube.com/" target="_blank">
                <img src="{{ asset('img/youtube.png') }}" alt="YouTube">
            </a>
            <a class="instagram" href="https://www.instagram.com/" target="_blank">
                <img src="{{ asset('img/instagram.png') }}" alt="Instagram">
            </a>
            <a class="twitter" href="https://x.com/" target="_blank">
                <img src="{{ asset('img/twitter.png') }}" alt="Twitter">
            </a>
        </div>
    </div>

    <div class="area-links">
        <h2>Acesse</h2>
        <ul class="lista-links">
            <li><a href="{{ route('site.principal') }}">Home</a></li>
            <li><a href="{{ route('site.sobrenos') }}">Sobre Nós</a></li>
            <li><a href="{{ route('app.pedido') }}">Pedidos</a></li>
            <li><a href="{{ route('app.produto') }}">Produtos</a></li>
            <li><a href="{{ route('app.cliente') }}">Clientes</a></li>
            <li><a href="{{ route('app.fornecedor') }}">Fornecedores</a></li>
        </ul>
    </div>

    <div class="area-contato">
        <h2>Contato</h2>
        <span class="numero-contato">(54) 3333-4444</span>
        <span class="email-contato">appsupergestao@gmail.com.br</span>
    </div>
</footer>
