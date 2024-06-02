<!DOCTYPE html>
<html lang="pt-br">
        @include('app.layouts.head')
    <body>
        @include('app.layouts._partials.header')
        @yield('conteudo')
    </body>
        @stack('scripts')
</html>
