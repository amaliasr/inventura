<link href="<?= base_url(); ?>assets/smm/login.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>assets/smm/purchase_order.css" rel="stylesheet" type="text/css">
<main class="background">
    <div class="row h-100">
        <div class="col-12 col-md-6 bg-hijau h-100 align-self-center d-none d-md-none d-lg-block d-lg-block">
            <div class="centered">
                <div class="container justify-content-center mt-4 mt-sm-0 text-center">
                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                    <lottie-player src="<?= base_url() ?>assets/json/factory.json" mode="bounce" background="transparent" speed="2" style="width: 100%; height: 500px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 bg-white h-100">
            <div class="row h-100 d-flex align-self-center justify-content-center">
                <div class="col-8 h-100 align-items-center align-content-center flex-wrap">
                    <div class="centered">
                        <div class="container justify-content-center">
                            <!-- <img class="mb-3" src="<?= base_url() ?>assets/image/logo/SMM.png" style="width: 50px;"> -->
                            <h1 class="text-dongker fw-bold"><b>Welcome Back, Buddy !</b></h1>
                            <p class="m-0 small">Learn to level up yout life. Love the wotk, the grnd, the sweat, and the hard work. It pays off in the end.</p>
                            <div class="alert alert-danger mt-2 p-3 d-none" id="alertSalah" role="alert" style="font-size:12px;">
                                <b>Username atau Password</b> tidak sesuai, silahkan coba lagi. Atau jika belum memiliki akses, silahkan hubungi pihak IT
                            </div>
                            <form class="m-0 mt-3">
                                <div class="mb-3">
                                    <input class="form-control" id="inputUsername" type="text" tabindex="1" placeholder="Enter Username" />
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" id="inputPassword" type="password" tabindex="2" placeholder="Enter password" />
                                </div>
                                <div class="mt-4 mb-0">
                                    <button class="btn btn-dark float-end" style="cursor: pointer" type="submit" id="btnLogin" tabindex="3">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="modal" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document" id="modalDialog">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">

            </div>
            <div class="modal-body" id="modalBody">

            </div>
            <div class="modal-footer" id="modalFooter">

            </div>
        </div>
    </div>
</div>
<script>
    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) {
            delta /= 2;
        }

        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }

        setTimeout(function() {
            that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };
    $(document).ready(function() {
        $('#layoutAuthentication_footer').addClass('d-none')
    })
    var username, password;
    $(document).on('click', '#btnLogin', function(e) {
        login()
    })

    function login() {
        username = $('#inputUsername').val()
        password = $('#inputPassword').val()
        auth(username, password);
    }
    $('#inputPassword').on('keypress', function(event) {
        if (event.which === 13) { // Tombol Enter ditekan
            event.preventDefault();
            login();
        }
    });
    var dataLogin = ''
    const auth = (username, password) => {
        var restURL = "<?= api_url('login'); ?>"
        $.ajax({
            url: restURL,
            method: "POST",
            data: {
                username: username,
                password: password
            },
            dataType: 'JSON',
            error: function(xhr) {
                $('#btnLogin').html('Login').removeAttr('disabled', true);
                $('#alertSalah').removeClass('d-none')
            },
            beforeSend: function() {
                $('#btnLogin').html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...').attr('disabled', true);
                $('#alertSalah').addClass('d-none')
            },
            success: function(response) {
                // console.log(response)
                $('#btnLogin').html('Login').removeAttr('disabled', true);
                $('#alertSalah').addClass('d-none')
                if (response['success'] == true) {
                    let data = response['data'];
                    dataLogin = data
                    // console.log(dataLogin)
                    chooseRole(data)
                }
            }
        });
        return false;
    }

    function chooseRole(data) {
        $('#modal').modal('show')
        $('#modalDialog').addClass('modal-dialog modal-dialog-scrollable modal-dialog-centered');
        var html_header = '';
        html_header += '<p class="m-0 fw-bold">Login As</p>';
        html_header += '<button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>';
        $('#modalHeader').html(html_header);
        var html_body = '';
        html_body += '<div class="row">'
        html_body += '<div class="col-12">'
        var a = 0
        data.roles.forEach(e => {
            html_body += '<div class="card shadow-none mb-2 card-hoper pointer" onclick="sessionLogin(' + a++ + ')">'
            html_body += '<div class="card-body">'

            html_body += '<div class="row justify-content-between">'
            html_body += '<div class="col-auto align-self-center">'
            html_body += '<p class="m-0 small-text">' + e.name + '</p>'
            html_body += '<p class="m-0 fw-bolder">' + e.login_data.name + '</p>'
            html_body += '</div>'
            html_body += '<div class="col-1 align-self-center">'
            html_body += '<i class="fa fa-chevron-right"></i>'
            html_body += '</div>'
            html_body += '</div>'

            html_body += '</div>'
            html_body += '</div>'
        });
        html_body += '</div>'
        html_body += '</div>'
        $('#modalBody').html(html_body);
        var html_footer = '';
        html_footer += '<button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">Batal</button>'
        $('#modalFooter').html(html_footer);
    }

    function sessionLogin(index) {
        var dataRole = dataLogin.roles[index]
        var sessions = [];
        sessions = {
            id: dataLogin['id'],
            username: dataLogin['username'],
            name: dataLogin['name'],
            roles: dataRole
        }
        $.ajax({
            type: "POST",
            data: sessions,
            url: base_url + "Auth/setSessions",
            dataType: 'JSON',
            error: function(e) {
                console.log(e)
            },
            success: function(response) {
                if (response['success'] == true) {
                    if ('<?= $this->input->cookie('link') ?>' == "") {
                        window.location = base_url + "dashboard";
                    } else {
                        window.location = '<?= $this->input->cookie('link') ?>'
                    }
                }
            }
        })
    }
</script>