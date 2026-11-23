(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const video = document.getElementById('asbc-player');
        const status = document.getElementById('asbc-player-status');
        const retry = document.getElementById('asbc-player-retry');
        if (!video || !status || !retry) return;

        const primary = video.dataset.streamPrimary || '';
        const backupUrl = video.dataset.streamBackup || '';
        let hls = null;
        let usingBackup = false;
        let nativePlayback = false;

        function setStatus(message) {
            status.textContent = message;
        }

        function clearPlayer() {
            nativePlayback = false;
            if (hls) {
                hls.destroy();
                hls = null;
            }
            video.pause();
            video.removeAttribute('src');
            video.load();
        }

        function tryPlay() {
            const promise = video.play();
            if (promise && typeof promise.catch === 'function') {
                promise.catch(function () {
                    setStatus('Pressione Reproduzir para assistir à transmissão.');
                });
            }
        }

        function failed() {
            if (!usingBackup && backupUrl && backupUrl !== primary) {
                usingBackup = true;
                setStatus('Sinal principal indisponível. Conectando ao sinal reserva...');
                loadStream(backupUrl);
                return;
            }
            clearPlayer();
            setStatus('Transmissão indisponível no momento. Use "Tentar novamente".');
        }

        function loadStream(url) {
            clearPlayer();

            if (!url) {
                setStatus('Endereço da transmissão não configurado.');
                return;
            }

            setStatus(usingBackup ? 'Conectando ao sinal reserva...' : 'Conectando ao sinal ao vivo...');

            // Safari e iOS têm suporte HLS nativo, mesmo sem a biblioteca externa.
            if (video.canPlayType('application/vnd.apple.mpegurl')) {
                nativePlayback = true;
                video.src = url;
                video.load();
                tryPlay();
                return;
            }

            if (typeof Hls === 'undefined' || !Hls.isSupported()) {
                setStatus('Este navegador não oferece suporte à transmissão HLS.');
                return;
            }

            try {
                hls = new Hls();
                hls.on(Hls.Events.MANIFEST_PARSED, function () {
                    tryPlay();
                });
                hls.on(Hls.Events.ERROR, function (_event, data) {
                    if (data && data.fatal) failed();
                });
                hls.loadSource(url);
                hls.attachMedia(video);
            } catch (_error) {
                failed();
            }
        }

        video.addEventListener('playing', function () {
            setStatus(usingBackup ? 'Assistindo pelo sinal reserva.' : 'Transmissão ao vivo.');
        });
        video.addEventListener('error', function () {
            if (nativePlayback) failed();
        });
        retry.addEventListener('click', function () {
            usingBackup = false;
            loadStream(primary);
        });
        window.addEventListener('pagehide', clearPlayer);

        loadStream(primary);
    });
}());
