export function fadeOut($element, time) {
    if ($element) {
        let fps = 30;
        let interval = 1000 / fps;
        let frames = time / fps;

        let opacityMin = 0;
        let opacityMax = 1;
        let opacityPerFrame = (opacityMax - opacityMin) / frames;

        let timer = setInterval(animate, interval);

        let counter = 1;
        function animate() {
            let propertyValue = opacityMax - counter * opacityPerFrame;

            if (propertyValue > opacityMax) {
                $element.style.opacity = "1";
                clearInterval(timer);
            }
            if (propertyValue < opacityMin) {
                $element.style.opacity = "0";
                $element.style.display = "none";
                clearInterval(timer);
            }

            $element.style.opacity = "" + propertyValue;
            counter++;
        }
    }
}

export function slideup($button, $content) {
    let extraHeight = 4 * 4 * 2;
    if ($button && $content) {
        $content.style.position = 'relative';

        $content.style.maxHeight = 'none';
        $content.style.overflowY = 'visible';
        let contentHeight = $content.offsetHeight + extraHeight;

        $content.style.transition = 'max-height 400ms ease-in-out';

        if ($content.classList.contains('open')) {
            $content.style.maxHeight = contentHeight + 'px';
        } else {
            $content.style.maxHeight = '0';
            $content.style.overflowY = 'hidden';
        }

        $button.addEventListener('click' , function(event) {
            event.preventDefault();
            if ($content.classList.contains('open')) {
                $content.style.maxHeight = '0';
                $content.style.overflowY = 'hidden';
            } else {
                $content.style.maxHeight = contentHeight + 'px';
                setTimeout(function() {
                    $content.style.overflowY = 'visible';
                }, 400);
            }

            $button.classList.toggle('open');
            $content.classList.toggle('open');
        }, false);
    }
}

export function slideuptr($button, $contents) {
    if ($button && $contents) {
        $button.addEventListener('click' , function(event) {
            event.preventDefault();
            $button.classList.toggle('open');
            $contents.forEach(($content) => {
                $content.classList.toggle('open');
            });
        }, false);
    }
}
