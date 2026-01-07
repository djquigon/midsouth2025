document.addEventListener('DOMContentLoaded', function () {
    const toggleSections = document.querySelectorAll('.toggles');
    if (!toggleSections || toggleSections.length === 0) return;

    toggleSections.forEach((section) => {
        if (section.classList.contains('numbered-list')) {
            initNumberedListSection(section);
        } else {
            initStandardSection(section);
        }
    });

    function setToggleState(trigger, toggleBox, toggleElement, isOpen) {
        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        toggleBox.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
        toggleBox.style.display = isOpen ? 'block' : 'none';
        if (toggleElement) {
            toggleElement.classList.toggle('active', isOpen);
        }
    }

    function initStandardSection(section) {
        const toggles = section.querySelectorAll('.toggle');
        if (!toggles || toggles.length === 0) return;

        function toggleBehavior(e) {
            e.preventDefault();
            const trigger = e.target.closest('.toggle__trigger');
            if (!trigger || !section.contains(trigger)) return;

            const toggleElement = trigger.closest('.toggle');
            const toggleBox = trigger.nextElementSibling;
            if (!toggleBox) return;

            const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
            setToggleState(trigger, toggleBox, toggleElement, !isExpanded);
        }

        toggles.forEach((toggle) => {
            const trigger = toggle.querySelector('.toggle__trigger');
            const toggleBox = toggle.querySelector('.toggle__box');
            if (!trigger || !toggleBox) return;

            if (toggleBox.getAttribute('aria-hidden') !== 'false') {
                toggleBox.style.display = 'none';
            }

            trigger.addEventListener('click', toggleBehavior);
        });
    }

    function initNumberedListSection(section) {
        const mq = window.matchMedia('(max-width: 769px)');

        function applyLayout() {
            const toggles = section.querySelectorAll('.toggle');
            if (!toggles || toggles.length === 0) return;

            if (mq.matches) {
                // Mobile: behave like standard toggles
                toggles.forEach((toggle) => {
                    const trigger = toggle.querySelector('.toggle__trigger');
                    const toggleBox = toggle.querySelector('.toggle__box');
                    if (!trigger || !toggleBox) return;

                    trigger.removeAttribute('aria-disabled');

                    // Default state from PHP is collapsed; keep it consistent.
                    const shouldBeOpen =
                        trigger.getAttribute('aria-expanded') === 'true' ||
                        toggleBox.getAttribute('aria-hidden') === 'false';

                    setToggleState(trigger, toggleBox, toggle, shouldBeOpen);
                });
            } else {
                // Desktop: no toggle functionality; all open
                toggles.forEach((toggle) => {
                    const trigger = toggle.querySelector('.toggle__trigger');
                    const toggleBox = toggle.querySelector('.toggle__box');
                    if (!trigger || !toggleBox) return;

                    trigger.setAttribute('aria-disabled', 'true');
                    setToggleState(trigger, toggleBox, toggle, true);
                });
            }
        }

        function onClick(e) {
            // Desktop: no toggle functionality
            if (!mq.matches) return;

            e.preventDefault();
            const trigger = e.target.closest('.toggle__trigger');
            if (!trigger || !section.contains(trigger)) return;

            const toggleElement = trigger.closest('.toggle');
            const toggleBox = trigger.nextElementSibling;
            if (!toggleBox) return;

            const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
            setToggleState(trigger, toggleBox, toggleElement, !isExpanded);
        }

        section.addEventListener('click', onClick);
        applyLayout();

        if (typeof mq.addEventListener === 'function') {
            mq.addEventListener('change', applyLayout);
        } else {
            mq.addListener(applyLayout);
        }
    }
});
