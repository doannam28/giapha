<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('button_admin')) {
    function button_admin($args = array('add', 'delete'))
    {
        $_this = &get_instance();
        $controller = $_this->uri->segment(2);
        if ($_this->session->userdata['admin_group_id'] == 1) {
            if (in_array('add', $args)) {
                showButtonAdd();
            }
            if (in_array('delete', $args)) {
                showButtonDelete();
            }
            if (in_array('update', $args)) {
                showButtonUpdate();
            }
            showButtonReload();
        } else {
            if (in_array('add', $args)) {
                if (isset($_this->session->admin_permission[$controller]['add'])) {
                    showButtonAdd();
                }
            }
            if (in_array('delete', $args)) {
                if (isset($_this->session->admin_permission[$controller]['delete'])) {
                    showButtonDelete();
                }
            }
            if (in_array('update', $args)) {
                if (isset($_this->session->admin_permission[$controller]['update'])) {
                    showButtonUpdate();
                }
            }
            showButtonReload();
        }
    }
}
if (!function_exists('showButtonAdd')) {
    function showButtonAdd()
    {
        echo '<a href="javascript:;" class="btn btn-primary m-btn m-btn--icon m-btn--air m-btn--pill btnAddForm m-1">
                <span>Add</span>
            </a> ';
    }
}

if (!function_exists('showButtonDelete')) {
    function showButtonDelete()
    {
        echo '<a href="javascript:;" class="btn btn-danger m-btn m-btn--icon m-btn--air m-btn--pill btnDeleteAll m-1">
                <span>Delete</span>
            </a> ';
    }
}

if (!function_exists('showButtonReload')) {
    function showButtonReload()
    {
        echo '<a href="javascript:;" class="btn btn-info m-btn m-btn--icon m-btn--air m-btn--pill btnReload m-1">
                <span>Refresh</span>
            </a>';
    }
}

if (!function_exists('showButtonUpdate')) {
    function showButtonUpdate()
    {
        echo '<button type="submit" class="btn btn-primary m-btn m-btn--icon m-btn--air m-btn--pill btnAddForm ml-1">
                <span>
                    <i class="la la-plus"></i>
                    <span>
                        Update Graveyard
                    </span>
                </span>
            </button>';
    }
}
