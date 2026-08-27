/* ========================================= *\
   User Dashboard - Main JavaScript
   Unified Interactions for Upsheba Platform
\* ========================================= */

(function($) {
    'use strict';

    // ==========================================
    // Global Variables
    // ==========================================
    var $sidebar = $('.app-sidebar');
    var $mainContent = $('.main-content');
    var $preloader = $('#preloader');
    var $sidebarToggle = $('#sidebarToggle');
    var dataTables = {};

    // ==========================================
    // Initialize on Document Ready
    // ==========================================
    $(function() {
        initLayout();
        initSidebar();
        initDataTable();
        initFormComponents();
        initTooltips();
        initNotifications();
        initPreloader();
        bindEvents();
    });

    // ==========================================
    // Layout Initialization
    // ==========================================
    function initLayout() {
        // Smooth scrolling for anchor links
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            var target = $(this.hash);
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 300);
            }
        });

        // Auto-hide preloader
        setTimeout(function() {
            if ($preloader.is(':visible')) {
                $preloader.fadeOut(300);
            }
        }, 1000);
    }

    // ==========================================
    // Sidebar Toggle Functionality
    // ==========================================
    function initSidebar() {
        $sidebarToggle.on('click', function(e) {
            e.preventDefault();
            toggleSidebar();
        });

        // Close sidebar on mobile when clicking outside
        $(document).on('click', function(e) {
            if ($(window).width() < 1200 && 
                !$sidebar.is(e.target) && 
                !$sidebar.has(e.target).length &&
                !$sidebarToggle.is(e.target) &&
                !$sidebarToggle.has(e.target).length) {
                if ($sidebar.hasClass('show')) {
                    $sidebar.removeClass('show');
                }
            }
        });

        // Handle window resize
        var resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if ($(window).width() >= 1200) {
                    $sidebar.removeClass('show');
                }
            }, 250);
        });
    }

    function toggleSidebar() {
        $sidebar.toggleClass('collapsed');
        $mainContent.toggleClass('expanded');
        
        // Save state to localStorage
        if (typeof(Storage) !== 'undefined') {
            localStorage.setItem('sidebar-collapsed', $sidebar.hasClass('collapsed'));
        }
    }

    // ==========================================
    // DataTables Initialization
    // ==========================================
    function initDataTable() {
        var $dataTables = $('table.datatable, .datatable table, table.dt-responsive');
        
        if (!$dataTables.length) return;

        $dataTables.each(function(index) {
            var $table = $(this);
            var tableId = $table.attr('id') || 'datatable-' + index;
            $table.attr('id', tableId);

            // Default options
            var options = {
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: false,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                pageLength: 25,
                language: {
                    search: '<div class="input-group input-group-sm mb-3">' +
                            '<span class="input-group-text"><i class="fas fa-search"></i></span>' +
                            '<input type="search" class="form-control form-control-sm" placeholder="Search...">' +
                            '</div>',
                    searchPlaceholder: 'Search records...',
                    lengthMenu: 'Show _MENU_ entries',
                    zeroRecords: 'No matching records found'
                },
                dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>' +
                     '<"table-responsive"t>' +
                     '<"row mt-3"<"col-md-5"i><"col-md-7"p>>',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn btn-sm btn-outline-primary',
                        text: '<i class="fas fa-copy me-1"></i> Copy'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm btn-outline-success',
                        text: '<i class="fas fa-file-excel me-1"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-outline-danger',
                        text: '<i class="fas fa-file-pdf me-1"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-outline-secondary',
                        text: '<i class="fas fa-print me-1"></i> Print'
                    }
                ],
                drawCallback: function(settings) {
                    // Add custom styling to pagination
                    var $pagination = $('#' + tableId + '_paginate');
                    $pagination.addClass('d-flex justify-content-center');
                    $pagination.find('.paginate_button').addClass('btn btn-sm btn-outline-primary mx-1');
                    $pagination.find('.paginate_button.current').removeClass('btn-outline-primary').addClass('btn-primary');
                    $pagination.find('.paginate_button.previous').html('<i class="fas fa-chevron-left"></i>');
                    $pagination.find('.paginate_button.next').html('<i class="fas fa-chevron-right"></i>');
                }
            };

            // Merge with data attributes
            var customOptions = $table.data('options');
            if (customOptions) {
                options = $.extend(true, options, customOptions);
            }

            // Initialize DataTable
            dataTables[tableId] = $table.DataTable(options);

            // Add custom styling to info
            $('#' + tableId + '_info').addClass('text-muted small');
            $('#' + tableId + '_filter input')
                .addClass('form-control form-control-sm')
                .css({'width': '100%'});
        });
    }

    // ==========================================
    // Form Components Initialization
    // ==========================================
    function initFormComponents() {
        // Custom file input
        $('.form-file-input').on('change', function(e) {
            var fileName = $(this).val().split('\\').pop();
            var $label = $(this).next('.form-file-label');
            if (fileName) {
                $label.find('.custom-label-text').text(fileName);
                $label.addClass('has-file');
            } else {
                $label.removeClass('has-file');
            }
        });

        // Date pickers
        initDatePickers();

        // Select2 enhancements
        if ($.fn.select2) {
            $('.form-control.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // Auto-calculate totals
        initAutoCalculate();

        // Form validation
        initFormValidation();
    }

    function initDatePickers() {
        var $datePickers = $('.datepicker, [data-toggle="datepicker"]');
        
        $datePickers.each(function() {
            var $input = $(this);
            if (!$input.data('flatpickr')) {
                $input.flatpickr({
                    dateFormat: 'Y-m-d',
                    allowInput: true,
                    locale: 'default'
                });
            }
        });
    }

    function initAutoCalculate() {
        var $calcFields = $('[data-calculate]');
        
        if (!$calcFields.length) return;

        $calcFields.on('input change', function() {
            var $form = $(this).closest('form');
            var total = 0;
            
            $form.find('[data-calculate]').each(function() {
                var val = parseFloat($(this).val().replace(/[^0-9.-]+/g, '')) || 0;
                total += val;
            });
            
            var $totalField = $form.find('[data-total]');
            if ($totalField.length) {
                $totalField.val(total.toFixed(2));
            }
        });
    }

    function initFormValidation() {
        // Bootstrap 5 validation
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.from(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                $(form).addClass('was-validated');
            }, false);
        });
    }

    // ==========================================
    // Tooltips and Popovers
    // ==========================================
    function initTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }

    // ==========================================
    // Notifications
    // ==========================================
    function initNotifications() {
        // Auto-dismiss alerts
        setTimeout(function() {
            $('.alert.alert-dismissible').fadeTo(5000, 0.5).slideUp(500, function() {
                $(this).slideUp(500);
            });
        }, 5000);

        // Notification click handler
        $('.notification-mark-read').on('click', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.notification-item');
            $item.fadeOut(300);
        });
    }

    // ==========================================
    // Preloader Management
    // ==========================================
    function initPreloader() {
        $(window).on('load', function() {
            $preloader.fadeOut(300, function() {
                $(this).remove();
            });
        });
    }

    // ==========================================
    // Event Bindings
    // ==========================================
    function bindEvents() {
        // Confirm delete actions
        $(document).on('click', '.confirm-delete', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });

        // Modal handlers
        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            $(this).find('.was-validated').removeClass('was-validated');
        });

        // Table action buttons
        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            if (url) {
                window.location.href = url;
            }
        });

        // Dynamic content loader
        $(document).on('click', '[data-load="modal"]', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var $modal = $('#ajax-modal');
            
            if (!$modal.length) {
                $modal = $('<div class="modal fade" id="ajax-modal"><div class="modal-dialog"><div class="modal-content"></div></div></div>').appendTo('body');
            }
            
            $.get(url, function(data) {
                $modal.find('.modal-content').html(data);
                $modal.modal('show');
            });
        });

        // Toast notifications
        window.showToast = function(message, type) {
            var $toast = $('<div class="toast align-items-center text-white bg-' + (type || 'primary') + ' border-0" role="alert">' +
                          '<div class="d-flex">' +
                          '<div class="toast-body">' + message + '</div>' +
                          '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
                          '</div>' +
                          '</div>');
            
            $('#toast-container').append($toast);
            $toast.toast({ delay: 3000 }).toast('show');
            
            $toast.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        };
    }

    // ==========================================
    // Public API
    // ==========================================
    window.UserDashboard = {
        refreshTable: function(tableId) {
            if (dataTables[tableId]) {
                dataTables[tableId].ajax.reload(null, false);
            }
        },
        
        toggleSidebar: toggleSidebar,
        
        showToast: function(message, type) {
            showToast(message, type);
        },
        
        initDatePicker: function(selector) {
            $(selector).flatpickr({
                dateFormat: 'Y-m-d',
                allowInput: true
            });
        }
    };

})(jQuery);

// ==========================================
// Global Helper Functions
// ==========================================
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number;
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
    var s = '';
    var toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + (Math.round(n * k) / k).toFixed(prec);
    };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

// ==========================================
// Auto-initialize on load
// ==========================================
$(document).ready(function() {
    // Initialize all components
    $('.select2').select2({
        width: '100%',
        theme: 'bootstrap-5'
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});