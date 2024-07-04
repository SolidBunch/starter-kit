<?php

/**
 * Block view template
 *
 * @var $data array
 */

defined('ABSPATH') || exit;

$data = $data ?? [];

?>
<aside class="sidebar col-12 py-1 px-2 py-lg-0 px-lg-0 mb-5 mb-lg-0">
    <div class="d-flex d-lg-none align-items-center">
        <button class="btn text-primary px-0 py-1 doc_toggler_btn navbar-toggler me-auto"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDocs"
                aria-controls="offcanvasDocs"
                aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" aria-hidden="true" focusable="false" viewBox="0 0 24 24">
                <path d="M17,11H3c-0.6,0-1-0.4-1-1s0.4-1,1-1h14c0.6,0,1,0.4,1,1S17.6,11,17,11z"></path>
                <path d="M21,7H3C2.4,7,2,6.6,2,6s0.4-1,1-1h18c0.6,0,1,0.4,1,1S21.6,7,21,7z"></path>
                <path d="M21,15H3c-0.6,0-1-0.4-1-1s0.4-1,1-1h18c0.6,0,1,0.4,1,1S21.6,15,21,15z"></path>
                <path d="M17,19H3c-0.6,0-1-0.4-1-1s0.4-1,1-1h14c0.6,0,1,0.4,1,1S17.6,19,17,19z"></path>
            </svg>
            <?php esc_html_e('Menu', 'starter-kit'); ?>
        </button>
        <a href="#"><?php esc_html_e('Return to top', 'starter-kit'); ?></a>
    </div>
    <div class="offcanvas-lg offcanvas-start doc_offcanvas"
         tabindex="-1" id="offcanvasDocs"
         aria-labelledby="offcanvasDocsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDocsLabel"><?php esc_html_e('Docs:', 'starter-kit'); ?></h5>
            <button type="button" class="btn-close ms-auto"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                    data-bs-target="#offcanvasDocs">
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="offcanvas_content">
            <div class="py-2 px-lg-3">
                    <?php if (!empty($data['docPages'][0])) { ?>
                        <ul class="list-unstyled">
                            <?php foreach ($data['docPages'][0] as $docPageId => $docPage) { ?>
                                <li>
                                    <h5 class="mb-0">
                                        <a href="<?php echo $docPage['link'] ?? ''; ?>"
                                            <?php echo (get_the_ID() == $docPageId) ? 'class="active"' : ''; ?>>
                                            <?php echo $docPage['title'] ?? ''; ?>
                                        </a>
                                    </h5>
                                    <?php if (!empty($data['docPages'][$docPageId])) {
                                        $this->loadBlockView(
                                            'child-nav',
                                            [
                                                'docPages' => $data['docPages'],
                                                'parentPageId' => $docPageId,
                                            ],
                                            null,
                                            true
                                        );
                                    } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else {
                        echo '<p>' . esc_html__('No docs found.', 'starter-kit') . '</p>';
                    } ?>
                </div>
            </div>
        </div>
    </div>
</aside>