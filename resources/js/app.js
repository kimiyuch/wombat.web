// The usage bar in the window mock: hovering a part dims the others and names it below the bar, like in the app.
for (const bar of document.querySelectorAll('[data-usage-bar]')) {
    const segments = bar.querySelector('[data-usage-segments]');
    const label = bar.querySelector('[data-usage-label]');
    const hint = label.textContent;

    for (const slice of segments.querySelectorAll('[data-slice]')) {
        slice.addEventListener('pointerenter', () => {
            segments.querySelector('[data-hovered]')?.removeAttribute('data-hovered');
            slice.setAttribute('data-hovered', '');
            segments.setAttribute('data-hovering', '');
            label.textContent = slice.dataset.slice;
        });
    }

    segments.addEventListener('pointerleave', () => {
        segments.querySelector('[data-hovered]')?.removeAttribute('data-hovered');
        segments.removeAttribute('data-hovering');
        label.textContent = hint;
    });
}
