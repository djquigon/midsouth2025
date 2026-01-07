function initializeTeamMembersSlider() {
    const sliders = document.querySelectorAll('.team-members-slider');

    sliders.forEach((slider) => {
        const columnCount = slider.getAttribute('data-column-count');
        let slidesToShow = 1;

        // Set base slidesToShow based on column count
        switch (columnCount) {
            case 'two-col':
                slidesToShow = 2;
                break;
            case 'three-col':
                slidesToShow = 3;
                break;
            case 'four-col':
                slidesToShow = 4;
                break;
            default:
                slidesToShow = 1;
        }

        // Get the parent container of the slider
        const sliderContainer = slider.closest('.container');
        if (!sliderContainer) return;

        // Find the arrows and dots rows within the container
        const arrowsRow = sliderContainer.querySelector('.arrows-row');
        const dotsRow = sliderContainer.querySelector('.dots-row');

        const appendArrowsId = arrowsRow ? '#' + arrowsRow.id : null;
        const appendDotsId = dotsRow ? '#' + dotsRow.id : null;

        jQuery(slider).slick({
            appendArrows: appendArrowsId,
            appendDots: appendDotsId,
            dots: true,
            arrows: true,
            infinite: true,
            speed: 500,
            slidesToShow: slidesToShow,
            slidesToScroll: slidesToShow,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    });
}

// Initialize team member modals
function initializeTeamMemberModals() {
    // Add click event listeners to all "View Bio" buttons
    const viewBioButtons = document.querySelectorAll(
        '.team-member-content .button[data-modal-id]'
    );

    viewBioButtons.forEach((button) => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Get the modal ID from the data-modal-id attribute
            const modalId = '#' + this.getAttribute('data-modal-id');
            const modal = document.querySelector(modalId);

            if (modal) {
                // Show the modal
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close modal when clicking the close button
    const closeButtons = document.querySelectorAll(
        '.team-member-modal-close-button'
    );

    closeButtons.forEach((closeButton) => {
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            const modal = this.closest('.team-member-modal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modal when clicking outside of it (on the backdrop)
    const modals = document.querySelectorAll('.team-member-modal');

    modals.forEach((modal) => {
        modal.addEventListener('click', function (e) {
            // Only close if clicking on the modal backdrop (not the inner content)
            if (e.target === this) {
                this.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector(
                '.team-member-modal.active'
            );
            if (activeModal) {
                activeModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initializeTeamMembersSlider();
    initializeTeamMemberModals();
});
