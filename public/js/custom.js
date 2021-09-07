"use strict";

Window.Laravel = {
    paginationClass: 'page-link',
    listClass: 'render',
    selfUser: '',
    role: '',
    selfId: '',
};

/**
 * Ajax Request
 *
 * @param url
 * @param type
 * @param data
 * @param loading
 * @param form
 * @param file
 *
 * @returns {Promise<void>}
 */
const ajaxRequest = async function (url, type, data, loading = true, form = null, file = false) {
    setHeaders();
    let settings = {
        url: url,
        type: type,
        data: data,
        processData: true,
        beforeSend: () => {
            (loading) ? preLoader('show') : '';
        },

        success: (res) => {
            (loading) ? preLoader('hide') : '';

            if (!res.status)
            {
                if (res.message !== undefined)
                {
                    if (res.message !== '' && res.message !== null)
                    {
                        toastr.error(res.message);
                    }
                }

                return false;
            }

            if (res.status)
            {

                if (res.message !== '' && res.message !== null)
                {
                    toastr.success(res.message);
                }

                if(res.url !== undefined && res.url !== null)
                    if(res.message === null)
                        window.location.href = res.url;
                    else
                        setTimeout(() => { window.location.href = res.url }, 1000);
            }
        },

        error: (err) => {

            (loading) ? preLoader('hide') : '';

            if (err.status === 422)
            {
                let errors = (err.responseJSON)
                    ? err.responseJSON.errors
                    : JSON.parse(err.responseText).errors;

                populateErrors(form, errors);
                return;
            }

            if (err.responseJSON.message !== '' && err.responseJSON.message !== null)
            {
                toastr.error(err.responseJSON.message);
            }
        }
    };


    if (file !== false)
    {
        settings.processData = false;
        settings.contentType = false;
    }

    return await $.ajax(settings);
};

/**
 * Pre Loader Control
 *
 * @param state
 */
const preLoader = function (state) {
    let loader = $('body').find('#preloader');
    if(state === 'show')
    {
        loader.show();
        return;
    }

    loader.hide();
};

/**
 * Set Default Request Headers
 */
const setHeaders = function () {
    $.ajaxSetup({
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });
};

/**
 * @param selector
 * @param allowTime
 * @param allowOnlyTime
 * @param minDate
 */
const enableDatePicker = (selector, allowTime = true, minDate = true, allowOnlyTime = false) => {

    let settings = {
        language: 'en',
        timepicker: allowTime,
        classes: allowOnlyTime ? 'only-timepicker' : ''
    };

    allowOnlyTime ? settings.dateFormat = ' ' : settings.dateFormat = 'yyyy-mm-dd';
    minDate ? settings.minDate = new Date() : '';
    $(selector).datepicker(settings);

    if(allowOnlyTime)
        $('body').find('.only-timepicker .datepicker--content, .datepicker--nav').css({
            display: 'none'
        });
};

/**
 *
 * @param num
 * @returns {string}
 */
const numberFormat = (num) => {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
};

/**
 *
 * @param key
 * @param value
 */
const insertParam = (key, value) => {
    key = encodeURI(key); value = encodeURI(value);
    let kvp = document.location.search.substr(1).split('&');
    let i=kvp.length; let x; while(i--) {
        x = kvp[i].split('=');
        if (x[0]==key) {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }

    if(i<0) {kvp[kvp.length] = [key,value].join('=');}
    //this will reload the page, it's likely better to store this until finished
    return kvp.join('&');
};

/**
 *
 * @param form
 * @param data
 */
const populateFields = function (form, data) {
    $.each(data, function (key, value) {
        let ctrl = $('[name=' + key + ']', form);
        switch (ctrl.prop("type")) {
            case "radio":
            case "checkbox":
                ctrl.each(function () {
                    if ($(this).attr('value') === value) $(this).attr("checked", value);
                });
                break;
            default:
                ctrl.val(value);
        }
    });
};

/**
 *
 * @param form
 * @param errors
 */
const populateErrors = function (form, errors) {
    $.each(errors, function (key, message) {
        let $selector = $(form).find(`input[name=${key}], select[name=${key}]`);
        $(form).find(`.error-${key}`).remove();
        $selector.addClass('is-invalid');
        $selector.after(`<span style="display: block" class="invalid-feedback error-${key}" role="alert"><strong>${message}</strong></span>`);
    });
};

/**
 *
 * @param message
 * @returns {*}
 */
const confirm = function (message) {
    return swal({
        title: "Are you sure?",
        text: message,
        icon: "warning",
        buttons: [
            'No, cancel it!',
            'Yes, I am sure!'
        ],
        dangerMode: true,
    }).then(function (isConfirm) {
        return !!(isConfirm);
    });
};

/**
 *
 * @param file
 * @param target
 * @returns {Promise<void>}
 */
const livePreview = (file, target) => {
    let reader = new FileReader();
    reader.onload = function (e) {
        $(target).attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
};

/**
 *
 * @returns {{serverSide: boolean, processing: boolean}}
 */
const dataTableSettings = function () {
    return {
        serverSide: true,
        processing: true,
    };
};

/**
 *
 * @param selector
 * @param url
 * @param column
 * @param columnDef
 * @param target
 */
const dataTables = function (selector, url, column = null, columnDef = null, target = null) {
    let columns = column === null ? setBySelector(selector) : pushColumns(column);
    let settings = dataTableSettings();
    $(selector).DataTable({
        serverSide: settings.serverSide,
        processing: settings.processing,
        "ajax": {
            "url": url
        },
        "columns": columns,
        columnDefs: columnDef
    });
};

/**
 *
 * @param column
 * @returns {[]}
 */
const pushColumns = function (column) {
    let columns = [];
    column.forEach(col => {
        columns.push({data: col});
    });
    return columns;
};

/**
 *
 * @param selector
 * @returns {*[]}
 */
const setBySelector = function (selector) {
    let columns = [];
    $(selector).find('th').each((i, a) => {
        if ($(a).text() !== 'action') {
            columns.push($(a).text().replace(/\s+/g, '_').toLowerCase());
        }
    });
    return pushColumns(columns);
};

/**
 *
 * @returns {boolean}
 */
const authenticated = () => {
    return Window.Laravel.user !== '';
};

/**
 *
 * @returns {string}
 */
const myId = () => {
    return Window.Laravel.user;
};

/**
 *
 * @param selector
 */
const scrollDown = (selector) => {
    selector.animate({scrollTop: selector[0].scrollHeight});
};

/**
 *
 * @param value
 * @param phrase
 * @returns {string}
 */
const str_formatting = (value, phrase) => {
    return value < 1 ? 'Studio' : (value > 1 ? value + ' '+ phrase + "s" : value + ' '+ phrase);
};

/**
 * Toggle eye view
 */
const toggleEye = ($event) => {
    $event.toggleClass('fa-eye-slash');
    if($event.hasClass('fa-eye-slash')) {
        $event.siblings('input').attr('type', 'text');
    } else {
        $event.siblings('input').attr('type', 'password');
    }
};


$(() => {

    // Enable Loader On Each Page
    // preLoader('show');

    let $body = $('body');
    $body.on('submit', 'form.ajaxSearch', async function(e) {
        e.preventDefault();
        await ajaxRequest($(this).attr('href'), 'get', $(this).serialize()).then(res => {
            $('.render').html(res.view);
        })
    });

    // Pagination
    $body.on('click', `.${Window.Laravel.paginationClass}`, async function (e) {
        e.preventDefault();
        let href = $(this).attr('href')
        if (href === undefined)
            return;

        await ajaxRequest(href, 'GET', null, true).then(res => {
            $body.find(`.${Window.Laravel.listClass}`).html(res.view);
        });
    });

    $body.on('submit', '.ajax', async function (e) {
        e.preventDefault();
        let data = null, form = $(this), id = $(this).attr('id');
        let url = $(this).attr('action'), type = $(this).attr('method');
        let loading = $(this).attr('loading'), reset = $(this).attr('reset');
        let file = $(this).attr('enctype') !== undefined;

        if(!file)
            data = $(this).serialize();

        else
        {
            let files = $(this).find('input[type=file]'), fd = new FormData();

            if(files.length > 0)
            {
                $.each(files, (i, v) => {
                    fd.append($(v).attr('name'), $(`input[name=${$(v).attr('name')}]`)[0].files[0]);
                });
            }

            data = $(this).serializeArray();

            if(data.length > 0)
            {
                data.forEach(v => {
                    fd.append(v.name, v.value);
                });
            }

            data = fd;
        }

        // if (!form.valid()) return;

        await ajaxRequest(url, type, data, (loading !== 'false'), form, file).then(res => {

            if (reset === 'true')
            {
                let iVal = $(form).find('input[type=submit]').val();
                $(form).find('input, select, textarea').val('');
                $(form).find('input[type=submit]').val(iVal)
            }

            if (res.status)
                form.trigger(`form-success${id !== undefined ? '-' + id : ''}`, res.data);

            if(res.url !== undefined && res.url !== null)
                if(res.message === null)
                    window.location.href = res.url;
                else
                    setTimeout(() => { window.location.href = res.url }, 1000);

        }).catch(err => {
            // Do Something
        });
    });

    $body.on('click', '.delete-record,.confirm', function (e) {
        e.preventDefault();
        let href = $(this).parent().attr('href');
        swal({
            title: 'Are you sure?',
            text: $(this).attr('data-message') ?? "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0CC27E',
            cancelButtonColor: '#FF586B',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mr-5',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function () {
            window.location.href = href;
        }, function (dismiss) {
            // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
            if (dismiss === 'cancel') {
                swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    })
});

/**
 * Disable loader on page Loaded
 */
window.onload = function() {
    setTimeout(() => { preLoader('hide') }, 500);
};
