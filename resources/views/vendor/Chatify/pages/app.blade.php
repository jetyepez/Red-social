@include('Chatify::layouts.headLinks')

<div class="messenger">
    {{-- ----------------------Lista de usuarios/grupos---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- <div class="w-128 p-4 dark:bg-gray-800 {{ !!$id ? 'conversation-active' : '' }}"> --}}
        {{-- Header y barra de búsqueda --}}
        <div class="m-header ">
            <nav class="flex items-center justify-between mb-4">
                <a href="/" class="flex items-center gap-6">
                    <i class="fa-brands fa-rocketchat"></i>
                    <span>{{ config('chatify.name') }}</span>
                </a>
                {{-- botones del header --}}
                <nav class="m-header-right">
                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- barra de búsqueda --}}
            <input type="text" class="messenger-search" placeholder="Buscar" />
            {{-- Tabs --}}
            {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
        </div>
        {{-- tabs y listas --}}
        <div class="m-body contacts-container">
            {{-- listas [usuarios/grupos] --}}
            {{-- ---------------- [ pestaña de usuarios ] ---------------- --}}
            <div class="show messenger-tab users-tab app-scroll" data-view="users">
                {{-- secciones de favoritos --}}
                <div class="favorites-section">
                    <p class="messenger-title"><span>Favoritos</span></p>
                    <div class="messenger-favorites app-scroll-hidden"></div>
                </div>
                {{-- secciones de mensajes guardados --}}
                <p class="messenger-title"><span>Tu espacio</span></p>
                {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
                {{-- secciones de contactos --}}
                <p class="messenger-title"><span>Todos los mensajes</span></p>
                <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;">
                </div>
            </div>
            {{-- ---------------- [ pestaña de búsqueda ] ---------------- --}}
            <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Buscar</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Escribe para buscar..</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- ----------------------Área de mensajería---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            {{-- <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center"> --}}
            {{-- header back button, avatar and user name --}}
            {{-- <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <div class="avatar av-s header-avatar"
                        style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                    </div>
                    <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                </div> --}}
            {{-- header buttons --}}
            {{-- <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/"><i class="fas fa-home"></i></a>
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                </nav>
            </nav> --}}
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Conectado</span>
                <span class="ic-connecting">Conectando...</span>
                <span class="ic-noInternet">No hay conexión a internet</span>
            </div>
        </div>

        {{-- Área de mensajería --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                <p class="message-hint center-el"><span>Por favor, selecciona un chat para empezar a enviar mensajes</span></p>
            </div>
            {{-- indicador de escritura --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- formulario de envío de mensaje --}}
        @include('Chatify::layouts.sendForm')
    </div>
    {{-- ---------------------- Área de información ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- acciones de navegación --}}
        <nav>
            <p>Detalles del usuario</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
