<style>
    .nav-link {
        display: block !important;
        line-height: normal;
        font-size: .90em;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
        /* margin: 0rem !important;
        padding: 0rem !important;

        padding-top: 0.35rem !important;
        margin-top: 0.35rem !important;

        padding-bottom: 0.55rem !important;
        margin-bottom: 0.55rem !important;

        padding-left: 0.5rem !important;
        margin-left: 0.5rem !important; */

        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .nav-sub {
        padding-top: 0.35rem !important;
        margin-top: 0.35rem !important;
        padding-bottom: 0.35rem !important;
        margin-bottom: 0.35rem !important;
    }

    .nav-link-text {
        font-size: .95em;
    }

    .nav-link-text.active {
        font-size: .95em;
        font-weight: 600;
    }

    li.nav-link {
        padding-bottom: 0rem !important;
    }

    .nav-link-wrapper {
        transition: 0.1s;
    }

    li.nav-link:hover:not(.active) {
        color: var(--bs-dark) !important;
    }

    .nav-link-wrapper:hover {
        color: var(--bs-primary) !important;
    }

    .nav-link-wrapper.active {
        font-weight: 600;
        color: var(--bs-primary) !important;
    }

    .nav-link-wrapper.active>.nav-link-icon {
        font-weight: 600;
        color: var(--bs-primary) !important;
    }

    .collapsed>ul {
        visibility: hidden;
        opacity: 0;
        max-height: 0;
    }

    ul {
        margin: 0.75rem, 0;
        padding: 0;
        list-style: none;
        cursor: pointer;
        /* transition: all .3s; */
    }

    ul.sidenav-menu-nested {
        /* padding-top: 0.75rem !important; */
        margin-top: 0.75rem !important;
        padding-left: 0.45rem !important;
        margin-left: 0.45rem !important;
    }
</style>
<?php
$routeTemplate = [
    'invoices',
    'purchase-recap',
    'recap-shipment',
    'recap-puchase-supplier',
    'recap-warehouse-stock',
    'report-shipment',
    'history-purchase',
    'history-shipment',
    'shippings',
    'recap-production',
    'history-production',
    'receptions',
    'history-material',
]
?>
<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion text-capitalize" id="accordionSidenav">
                <div class="sidenav-menu-heading">Main Menu</div>
                <a class="nav-link" href="<?= base_url(); ?>">
                    <div class="nav-link-icon"><i class="fa fa-home"></i></div>
                    Beranda
                </a>
                <?php foreach ($permission as $key => $value) {
                    if (in_array($value['route'], $routeTemplate)) {
                ?>
                        <a class="nav-link" href="<?= base_url(); ?>page/<?= $value['route'] ?>">
                            <div class="nav-link-icon"><i class="fa fa-file-o"></i></div>
                            <?= $value['name'] ?>
                        </a>
                <?php
                    }
                } ?>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="row">
                    <div class="col-3 align-self-center text-center">
                        <img src="<?= base_url() ?>assets/image/gif/astronaut-1.svg" style="width: 50px;">
                    </div>
                    <div class="col-9 align-self-center">
                        <div class="sidenav-footer-subtitle">Logged in as:</div>
                        <div class="sidenav-footer-title lh-1"><?= $this->session->userdata('full_name') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var targetURL = window.location.href
        $("#layoutSidenav_nav .nav-link").removeClass("active");
        $("#layoutSidenav_nav .nav-link").each(function() {
            var href = $(this).attr("href");
            if (href === targetURL) {
                $(this).addClass("active");
            }
        });
    });
</script>