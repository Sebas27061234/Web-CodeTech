<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reproductor - CodeTech</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('admin/assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />
    <link rel="stylesheet" href="https://use.typekit.net/tlw5aua.css">
    <style>
        *{
            outline:0!important
        }
        body{
            height:100vh;
            width:100%;
            margin:0;
            margin:0;
            background-color:#ffffff
        }
        html{
            height:100vh;
            width:100vw;
        }
        .plyr{
            height: 100vh;
        }
        :root {
            --plyr-color-main: #0B3D56;
            --plyr-color-main-rgb: 11, 61, 86;
            --plyr-font-family: "lato", sans-serif;
            --plyr-control-icon-size: 23px;
            --plyr-range-track-height: 7px;
            --plyr-range-thumb-height: 15px;
        }
        .plyr__progress input[type=range] {
            cursor: pointer;
        }
        .plyr__controls__item.plyr__control{
            transition: all .5s ease-in-out;
        }
        .plyr__controls .plyr__progress input:focus ~ .plyr__progress__buffer{
            box-shadow:0 0 0 5px rgba(var(--plyr-color-main-rgb),.5);
            outline:0
        }
        .plyr__volume input[type=range]{
            height: 5px;
        }
        .plyr__volume input[type=range]:focus{
            box-shadow: 0 0 0 5px rgba(var(--plyr-color-main-rgb),.5) ;
        }
        .plyr__controls .plyr__progress__container {
            flex: 1;
            min-width: 0;
            position: absolute;
            bottom: 45px;
            width: 100%;
            padding-left: 5px!important;
            padding-right: 5px!important;
            margin-left: 0!important;
            margin-right: 0!important;
            left: 0!important;
        }

        @media (min-width: 480px){
            .plyr--video .plyr__controls {
                padding: 35px 10px 5px;
            }
        }

        @media (min-width: 400px){
            .plyr__controls .plyr__progress__container {
                bottom: 42px;
            }
        }

        .plyr__controls .plyr__controls__item:first-child {
            margin-left: 0;
            margin-right: 0;
        }
        .plyr__controls .plyr__controls__item.plyr__time--duration {
            padding: 0 5px;
            margin-right: auto;
        }
        .plyr__control--overlaid svg {
            width: 45px;
            height: 45px;
        }
        .plyr__control--overlaid{
            padding: 30px;
        }
        .plyr__control--overlaid:focus, .plyr__control--overlaid:hover {
            background: rgba(var(--plyr-color-main-rgb),.5)!important;
            transform: translate(-50%,-50%) scale(1.3);
        }
        .plyr--video a.plyr__control:hover, .plyr--video button:not(.plyr__control--overlaid).plyr__control:hover {
            box-shadow: 0 0 10px 5px rgba(var(--plyr-color-main-rgb),.5);
            -webkit-box-shadow: 0 0 10px 5px rgba(var(--plyr-color-main-rgb),.5);
            -moz-box-shadow: 0 0 10px 5px rgba(var(--plyr-color-main-rgb),.5);
        }
        .plyr .plyr-dock-text {
            color: #fff;
            left: 0;
            margin: 0;
            width: 100%;
            background: rgba(0,0,0,.8);
            background: linear-gradient(to bottom,rgba(0,0,0,.8) 0,rgba(0,0,0,.7) 30%,rgba(0,0,0,.65) 65%,rgba(0,0,0,0) 100%);
            padding: 1em 25% 2em 1em;
        }
        .plyr .plyr-dock-text {
            opacity: 1;
            font-size: 18px;
            font-family: var(--plyr-font-family);
            pointer-events: none;
            position: absolute;
            top: 0;
            transition: opacity 1s;
            z-index: 999;
        }
        .plyr .plyr-dock-title {
            font-weight: 700;
            letter-spacing: 1px;
            line-height: 1.333;
            margin-bottom: 0.333em;
        }
        .plyr .plyr-dock-title {
            margin: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        #plyr-playlist-list button{
            padding: calc(var(--plyr-control-spacing, 15px)*.7/1.5) calc(var(--plyr-control-spacing, 15px)*.7*1.5);
            font-size: 14px;
        }
        .plyr__videoL_play{
            background-color: var(--plyr-color-main);
            color: #fff !important;
            box-shadow: 0 0 10px 5px rgba(var(--plyr-color-main-rgb),.5);
        }
    </style>
    <style>
        .d-none{
            display: none !important;
        }
        .next-video-cont{
            display: flex;
            align-items: center;
            background-color: var(--plyr-color-main);
            color: #fff;
            width: 28%;
            height: 23%;
            position: absolute;
            right: 1%;
            bottom: 8%;
            border-radius: 20px;
            opacity: .8;
        }
        .thumbnail-video{
            width: 25%;
            height: 15vh;
            margin-left: 20px;
            margin-right: 15px;
            border-radius: 15px;
            border: 1px solid #fff;
            padding: 2px;
        }
        .thumbnail-video .img{
            border-radius: 15px;
            width: 100%;
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
        }
        .video-info{
            width: 60%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .video-info p{
            font-family: var(--plyr-font-family);
            font-size: 15px;
            margin-bottom: 18px;
            margin-right: 7px;
        }
        .video-info .circular-progress {
            position: relative;
            width: 40%;
            height: 12vh;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-info .circular-progress .outer-progress{
            height: 9vh;
            width: 92%;
            box-shadow: 6px 6px 10px -1px rgba(0, 0, 0, 0.15), -6px -6px 10px -1px rgba(32, 41, 54, 0.7);
            border-radius: 50%;
            padding: 15px;
        }

        .video-info .circular-progress .inner-progress{
            height: 9vh;
            width: 100%;
            box-shadow: inset 4px 4px 6px -1px rgba(0, 0, 0, 0.2), inset -4px -4px 6px -1px rgba(32, 41, 54, 0.7), -0.5px -0.5px 0px rgba(32, 41, 54, 1), 0.5px 0.5px 0px rgba(0, 0, 0, 0.15), 0px 12px 10px -10px rgba(0, 0, 0, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-info .circular-progress .inner-progress span{
            font-size: 20px;
            font-family: var(--plyr-font-family);
            font-weight: 600;
        }

        .video-info .circular-progress svg{
            position: absolute;
            top: 0;
            left: 0;
        }

        @media (max-width: 1200px) {
            .next-video-cont{
                bottom: 13%;
                width: 30%;
            }
            .video-info p{
                font-size: 11.5px;
                margin-bottom: 5px;
            }
            .video-info .circular-progress{
                width: 35%;
                height: 11vh;
            }
            .video-info .circular-progress .outer-progress{
                height: 8vh;
                width: 92%;
                padding: 8px;
            }
            .video-info .circular-progress .inner-progress{
                height: 8vh;
                width: 100%;
            }
            .video-info .circular-progress svg{
                height: 11vh;
            }
            .video-info .circular-progress svg circle{
                cx:28;
                cy:28;
                r:23;
                stroke-width:8;
            }
        }
        #nextvideoId{
            display: none;
        }
    </style>
</head>
<body>
    <video id="player" playsinline controls data-poster="/storage/files/{{ $video->poster }}">
        <source src="/storage/files/{{ $video->url }}" type="video/{{ $video->extension }}"/>
    </video>

    @if ($siguienteVideo)
    <div class="next-video-cont d-none">
        <div class="thumbnail-video">
            <div class="img" style="background-image: url(/storage/files/{{ $siguienteVideo->poster }});"></div>
            @php
                $key = \Defuse\Crypto\Key::loadFromAsciiSafeString(env('APP_ENCRYPTION_KEY'));
                $cadena = $siguienteVideo->idLeccionFile.';'.$siguienteVideo->nombre.';'.$siguienteVideo->extension.';'.$siguienteVideo->tamaño;
                $videoUrl = \Defuse\Crypto\Crypto::encrypt($cadena, $key)
            @endphp
            <span id="nextvideoId">{{ route('reproCursos',['video'=>$videoUrl]) }}</span>
        </div>
        <div class="video-info">
            <p>El siguiente video comenzará en:</p>
            <div class="circular-progress">
                <div class="outer-progress">
                    <div class="inner-progress">
                        <span id="cont-progress">5</span>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="12vh">
                    <defs>
                        <linearGradient id="GradientColor">
                            <stop offset="0%" stop-color="#32CD32" />
                            <stop offset="100%" stop-color="#1e9b1e" />
                        </linearGradient>
                    </defs>
                    <circle cx="47" cy="47" r="39" stroke-linecap="round" stroke="url(#GradientColor)" stroke-width="15" fill="none" stroke-dasharray="377" stroke-dashoffset="377"/>
                </svg>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>
    <script>
        const options = {
            enabled: true,
            title: '{{ $video->nombre }}',
            debug: false,
            autoplay: false,
            autopause: true,
            playsinline: true,
            seekTime: 5,
            volume: 70,
            muted: false,
            duration: null,
            displayDuration: true,
            invertTime: true,
            toggleInvert: true,
            ratio: null,
            clickToPlay: true,
            hideControls: true,
            resetOnEnd: false,
            disableContextMenu: true,
            loadSprite: true,
            iconPrefix: 'plyr',
            iconUrl: "{{ asset('admin/assets/images/repro/player.svg') }}",
            blankVideo: 'https://cdn.plyr.io/static/blank.mp4',
            quality: {
                default: 720,
                options: [4320, 2880, 2160, 1440, 1080, 720, 576, 480, 360, 240, 144],
                forced: false,
                onChange: null,
            },
            loop: {
                active: false,
            },

            speed: {
                selected: 1,
                options: [0.25, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2],
            },
            keyboard: {
                focused: true,
                global: false,
            },
            tooltips: {
                controls: true, 
                seek: false,
            },

            captions: {
                active: true,
                language: 'auto',
                update: false,
            },
            fullscreen: {
                enabled: true,
                fallback: true,
                iosNative: true, 
            },
            storage: {
                enabled: true,
                key: 'plyr',
            },
            controls: [
                'play-large',
                'restart',
                'rewind',
                'play',
                'fast-forward',
                'mute',
                'volume',
                'progress',
                'current-time',
                'duration',
                'captions',
                'settings',
                'pip',
                'airplay',
                'download',
                'fullscreen',
            ],
            settings: ['captions', 'quality', 'speed'],
            i18n: {
                restart: 'Restart',
                rewind: 'Rewind {seektime}s',
                play: 'Play',
                pause: 'Pause',
                fastForward: 'Forward {seektime}s',
                seek: 'Seek',
                seekLabel: '{currentTime} of {duration}',
                played: 'Played',
                buffered: 'Buffered',
                currentTime: 'Current time',
                duration: 'Duration',
                volume: 'Volume',
                mute: 'Mute',
                unmute: 'Unmute',
                enableCaptions: 'Enable captions',
                disableCaptions: 'Disable captions',
                download: 'Download',
                enterFullscreen: 'Enter fullscreen',
                exitFullscreen: 'Exit fullscreen',
                frameTitle: 'Player for {title}',
                captions: 'Captions',
                settings: 'Settings',
                pip: 'Picture-in-Picture',
                menuBack: 'Go back to previous menu',
                speed: 'Speed',
                normal: 'Normal',
                quality: 'Quality',
                loop: 'Loop',
                start: 'Start',
                end: 'End',
                all: 'All',
                reset: 'Reset',
                disabled: 'Disabled',
                enabled: 'Enabled',
                advertisement: 'Ad',
                qualityBadge: {
                    2160: '4K',
                    1440: '4K',
                    1080: '4K',
                    720: 'HD',
                    576: 'HD',
                    480: 'HD',
                    360: 'SD',
                    240: 'SD',
                    144: 'SD',
                },
            },
            urls: {
                download: null,
                vimeo: {
                    sdk: 'https://player.vimeo.com/api/player.js',
                    iframe: 'https://player.vimeo.com/video/{0}?{1}',
                    api: 'https://vimeo.com/api/oembed.json?url={0}',
                },
                youtube: {
                    sdk: 'https://www.youtube.com/iframe_api',
                    api: 'https://noembed.com/embed?url=https://www.youtube.com/watch?v={0}',
                },
                googleIMA: {
                    sdk: 'https://imasdk.googleapis.com/js/sdkloader/ima3.js',
                },
            },

            // Custom control listeners
            listeners: {
                seek: null,
                play: null,
                pause: null,
                restart: null,
                rewind: null,
                fastForward: null,
                mute: null,
                volume: null,
                captions: null,
                download: null,
                fullscreen: null,
                pip: null,
                airplay: null,
                speed: null,
                quality: null,
                loop: null,
                language: null,
            },
            events: [
                'ended',
                'progress',
                'stalled',
                'playing',
                'waiting',
                'canplay',
                'canplaythrough',
                'loadstart',
                'loadeddata',
                'loadedmetadata',
                'timeupdate',
                'volumechange',
                'play',
                'pause',
                'error',
                'seeking',
                'seeked',
                'emptied',
                'ratechange',
                'cuechange',

                // Custom events
                'download',
                'enterfullscreen',
                'exitfullscreen',
                'captionsenabled',
                'captionsdisabled',
                'languagechange',
                'controlshidden',
                'controlsshown',
                'ready',

                // YouTube
                'statechange',

                // Quality
                'qualitychange',

                // Ads
                'adsloaded',
                'adscontentpause',
                'adscontentresume',
                'adstarted',
                'adsmidpoint',
                'adscomplete',
                'adsallcomplete',
                'adsimpression',
                'adsclick',
            ],
            selectors: {
                editable: 'input, textarea, select, [contenteditable]',
                container: '.plyr',
                controls: {
                    container: null,
                    wrapper: '.plyr__controls',
                },
                labels: '[data-plyr]',
                buttons: {
                    play: '[data-plyr="play"]',
                    pause: '[data-plyr="pause"]',
                    restart: '[data-plyr="restart"]',
                    rewind: '[data-plyr="rewind"]',
                    fastForward: '[data-plyr="fast-forward"]',
                    mute: '[data-plyr="mute"]',
                    captions: '[data-plyr="captions"]',
                    download: '[data-plyr="download"]',
                    fullscreen: '[data-plyr="fullscreen"]',
                    pip: '[data-plyr="pip"]',
                    airplay: '[data-plyr="airplay"]',
                    settings: '[data-plyr="settings"]',
                    loop: '[data-plyr="loop"]',
                },
                inputs: {
                    seek: '[data-plyr="seek"]',
                    volume: '[data-plyr="volume"]',
                    speed: '[data-plyr="speed"]',
                    language: '[data-plyr="language"]',
                    quality: '[data-plyr="quality"]',
                },
                display: {
                    currentTime: '.plyr__time--current',
                    duration: '.plyr__time--duration',
                    buffer: '.plyr__progress__buffer',
                    loop: '.plyr__progress__loop', // Used later
                    volume: '.plyr__volume--display',
                },
                progress: '.plyr__progress',
                captions: '.plyr__captions',
                caption: '.plyr__caption',
            },
            classNames: {
                type: 'plyr--{0}',
                provider: 'plyr--{0}',
                video: 'plyr__video-wrapper',
                embed: 'plyr__video-embed',
                videoFixedRatio: 'plyr__video-wrapper--fixed-ratio',
                embedContainer: 'plyr__video-embed__container',
                poster: 'plyr__poster',
                posterEnabled: 'plyr__poster-enabled',
                ads: 'plyr__ads',
                control: 'plyr__control',
                controlPressed: 'plyr__control--pressed',
                playing: 'plyr--playing',
                paused: 'plyr--paused',
                stopped: 'plyr--stopped',
                loading: 'plyr--loading',
                hover: 'plyr--hover',
                tooltip: 'plyr__tooltip',
                cues: 'plyr__cues',
                marker: 'plyr__progress__marker',
                hidden: 'plyr__sr-only',
                hideControls: 'plyr--hide-controls',
                isIos: 'plyr--is-ios',
                isTouch: 'plyr--is-touch',
                uiSupported: 'plyr--full-ui',
                noTransition: 'plyr--no-transition',
                display: {
                    time: 'plyr__time',
                },
                menu: {
                    value: 'plyr__menu__value',
                    badge: 'plyr__badge',
                    open: 'plyr--menu-open',
                },
                captions: {
                    enabled: 'plyr--captions-enabled',
                    active: 'plyr--captions-active',
                },
                fullscreen: {
                    enabled: 'plyr--fullscreen-enabled',
                    fallback: 'plyr--fullscreen-fallback',
                },
                pip: {
                    supported: 'plyr--pip-supported',
                    active: 'plyr--pip-active',
                },
                airplay: {
                    supported: 'plyr--airplay-supported',
                    active: 'plyr--airplay-active',
                },
                tabFocus: 'plyr__tab-focus',
                previewThumbnails: {
                    // Tooltip thumbs
                    thumbContainer: 'plyr__preview-thumb',
                    thumbContainerShown: 'plyr__preview-thumb--is-shown',
                    imageContainer: 'plyr__preview-thumb__image-container',
                    timeContainer: 'plyr__preview-thumb__time-container',
                    // Scrubbing
                    scrubbingContainer: 'plyr__preview-scrubbing',
                    scrubbingContainerShown: 'plyr__preview-scrubbing--is-shown',
                },
            },
            attributes: {
                embed: {
                    provider: 'data-plyr-provider',
                    id: 'data-plyr-embed-id',
                    hash: 'data-plyr-embed-hash',
                },
            },
            ads: {
                enabled: false,
                publisherId: '',
                tagUrl: '',
            },
            previewThumbnails: {
                enabled: false,
                src: '',
            },
            vimeo: {
                byline: false,
                portrait: false,
                title: false,
                speed: true,
                transparent: false,
                customControls: true,
                referrerPolicy: null,
                premium: false,
            },
            youtube: {
                rel: 0,
                showinfo: 0,
                iv_load_policy: 3,
                modestbranding: 1,
                customControls: true,
                noCookie: false,
            },
            mediaMetadata: {
                title: '{{ $video->nombre }}',
                artist: 'CodeTechEvolution',
                album: '{{ $video->leccion }}',
                artwork: [],
            },
            markers: {
                enabled: true,
                points: [1, 10, 12.5, 15],
            },
        };

        const player = new Plyr('#player',options);
    </script>
    <script>
        const cont = document.querySelector('.plyr');
        var title = options.title;
        d = document.createElement("div");
        d.className = "plyr-dock-text";
        h = document.createElement("div"); 
        h.className = "plyr-dock-title"
        h.setAttribute('title', title);
        c = document.createTextNode(title);
        h.appendChild(c);
        d.appendChild(h);
        cont.appendChild(d);

        player.on('playing', (event) => {
            d.style.opacity = 0;
        });

        player.on('volumechange', (event) => {
            const volume = event.detail.plyr.volume;
            const button = document.querySelector('.plyr__volume button .icon--not-pressed use');
            if (volume <= 0.3) {
                var href = "{{ asset('admin/assets/images/repro/player.svg') }}#plyr-volume-down";
                button.setAttribute('href',href);
            } else{
                var href = "{{ asset('admin/assets/images/repro/player.svg') }}#plyr-volume"
                button.setAttribute('href',href);
            }
            console.log(event.detail.plyr)
        });

        player.on('ended', (event) => {
            const button = document.querySelector('button[data-plyr="restart"]');
            button.style.display = 'block';
        });

        player.on('progress', (event) => {
            const button = document.querySelector('button[data-plyr="restart"]');
            console.log(event.detail.plyr.ended);
            if (event.detail.plyr.currentTime != event.detail.plyr.duration) {
                button.style.display = 'none';
            } else if (event.detail.plyr.currentTime == event.detail.plyr.duration) {
                button.style.display = 'block';
            }
        });
    </script>
    <script>
        const menu = `<div class="plyr__controls__item plyr__menu plyr__playlist">
            <button aria-haspopup="true" aria-controls="plyr-playlist" aria-expanded="false" type="button" class="plyr__control" data-plyr="playlist" aria-pressed="false">
                <svg aria-hidden="true" focusable="false"><use xlink:href="{{ asset('admin/assets/images/repro/player.svg') }}#plyr-playlist"></use></svg>
                <span class="plyr__tooltip">Playlist</span>
            </button>
            <div class="plyr__menu__container" id="plyr-playlist" hidden="">
                <div>
                    <div id="plyr-playlist-list">
                        <button type="button" class="plyr__control">
                            <span aria-hidden="true">Lista de Reproducción</span>
                        </button>
                        <div role="menu">
                            @foreach ($lista as $videoL)
                            <button data-plyr="videoL" type="button" role="menuitem" class="plyr__control" aria-checked="false" value="/storage/files/{{ $videoL->url }}" data-title="{{ $videoL->nombre }}" data-poster="/storage/files/{{ $videoL->poster }}" data-ext ="{{ $videoL->extension }}">
                                <span>{{ $loop->iteration }}. {{ $videoL->nombre }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        
        player.on('loadeddata',()=>{
            const button = document.querySelector('button[data-plyr="restart"]');
            button.style.display = 'none';
            button.addEventListener('click',()=>{
                setTimeout(()=>{
                    button.style.display = 'none';
                },300);
            });

            const leftView = document.querySelector('.next-video-cont');

            if(!document.querySelector('button[data-plyr="playlist"]')){
                const btnCaptions = document.querySelector('button[data-plyr="captions"]');
                btnCaptions.insertAdjacentHTML('beforebegin', menu);
                const btnPlaylist = document.querySelector('button[data-plyr="playlist"]');
                btnPlaylist.addEventListener('click', () => {
                    console.log('click')
                    const menuPlaylist = document.querySelector('#plyr-playlist');
                    if (menuPlaylist.hasAttribute('hidden')){
                        console.log('mostrando')
                        menuPlaylist.removeAttribute('hidden');
                    } else menuPlaylist.setAttribute('hidden',"");
                });
                const btnsListVideos = document.querySelectorAll('button[data-plyr="videoL"]');
                btnsListVideos.forEach(button => {if(button.getAttribute('data-title')===document.querySelector('.plyr-dock-title').getAttribute('title')) button.classList.add('plyr__videoL_play')});
                btnsListVideos.forEach(button => {
                    button.addEventListener('click',()=>{
                        const newVideo = button.getAttribute('value');
                        const newTitle = button.getAttribute('data-title');
                        const newPoster = button.getAttribute('data-poster');
                        const newExt = button.getAttribute('data-ext');
                        const titleEl = document.querySelector('.plyr-dock-title');
                        titleEl.setAttribute('title',newTitle);
                        titleEl.textContent = newTitle;
                        document.querySelector('.plyr-dock-text').style.opacity = 1;
                        player.source = {
                            type: 'video',
                            title: newTitle,
                            sources: [
                                {
                                    src: newVideo,
                                    type: `video/${newExt}`,
                                    size: 720,
                                },
                            ],
                            poster: newPoster,
                        };
                    })
                });
            }
        });

        @if ($siguienteVideo)
        player.on('ended',()=>{
            var contador = 0;
            const contNextVideo = document.querySelector('.next-video-cont');
            contNextVideo.classList.remove('d-none');
            var progress = setInterval(()=>{
                const circleProgress = document.querySelector('.circular-progress svg circle');
                contador++;
                const oldStroke = parseInt(circleProgress.getAttribute('stroke-dasharray'),10);
                circleProgress.setAttribute('stroke-dasharray', oldStroke + 4.76);
                if(contador % 12 == 0) document.getElementById('cont-progress').innerText -= 1;
                if ( contador >= 60) {
                    clearInterval(progress);
                    var idNextVideo = document.getElementById('nextvideoId').textContent;
                    window.location.href = idNextVideo;
                }
            },100);

            contNextVideo.addEventListener('mouseover',()=>{
                clearInterval(progress);
            });

            contNextVideo.addEventListener('mouseout',()=>{
                if (contador < 60){
                    progress = setInterval(()=>{
                        const circleProgress = document.querySelector('.circular-progress svg circle');
                        contador++;
                        const oldStroke = parseInt(circleProgress.getAttribute('stroke-dasharray'),10);
                        circleProgress.setAttribute('stroke-dasharray', oldStroke + 4.76);
                        if(contador % 12 == 0) document.getElementById('cont-progress').innerText -= 1;
                        if ( contador >= 60) {
                            clearInterval(progress);
                            var idNextVideo = document.getElementById('nextvideoId').textContent;
                            window.location.href = idNextVideo;
                        }
                    },100);
                }
            });

            contNextVideo.addEventListener('click',()=>{
                clearInterval(progress);
                contNextVideo.classList.add('d-none');
            })
        })
        @endif
    </script>
</body>
</html>