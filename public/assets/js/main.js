function general() {
    /* Force 100% heigth */

    $('.workflow-draggable-menu').css('height', $(window).height());
    $('.dashboard-draggable-menu').css('height', $(window).height());
    $('.dashboard-draggable-menu-content').css('height', $(window).height());

    /* Classes change event */

    $('.draggable-menu-action').click(function () {
        $('.workflow-draggable-menu').toggleClass('workflow-draggable-menu-open');
        $('.workflow-draggable-menu-content').toggleClass('workflow-draggable-content-open');
    });
    $('.draggable-menu-action-dashboard').click(function () {
        $('.dashboard-draggable-menu').toggleClass('dashboard-draggable-menu-open');
        $('.main').toggleClass('main-drag');
        $('.dashboard-draggable-menu-content').toggleClass('dashboard-draggable-content-open');
        $('.calendar-data').toggleClass('calendar-data-constrict');
        $('.task-tools').toggleClass('task-tools-drag');
    });
    $('.draggable-menu-action-dashboard-mobile').click(function () {
        $('.main').toggleClass('main-drag-mobile');
        $('.dashboard-draggable-menu').toggleClass('dashboard-draggable-menu-open');
        $('.dashboard-draggable-menu-content').toggleClass('dashboard-draggable-content-open');
        $('.task-tools').toggleClass('task-tools-drag-mobile');
    });
    $('.task-tools-btn').click(function () {
        $('.task-tools-btn').toggleClass('task-tools-btn-clicked');
        $('.task-tools-content').toggleClass('task-tools-content-clicked');
        $('.main').toggleClass('main-drag-top');
        $('.task-tools').toggleClass('task-tools-top');
    });
    $('.attachments-a').click(function () {
        $('.idea-detail-modal-content').toggleClass('idea-detail-modal-content-drag');
    });
    $(".card-completed-check").change(function () {
        if ($(this).is(":checked")) {
            $('.card-completed').addClass("card-completed-checked");
        } else {
            $('.card-completed').removeClass("card-completed-checked");
        }
    });
    $(".card-completed-check").change(function () {
        if ($(this).is(":checked")) {
            $('.completed-p').addClass("completed-p-active");
        } else {
            $('.completed-p').removeClass("completed-p-active");
        }
    });
}

$(document).ready(function () {
    general();
});

$(window).resize(function () {
    general();
});

    $(window).load(function () {
        $(".scroll").customScrollbar();
    });