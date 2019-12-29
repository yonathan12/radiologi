<?php 
function is_logged_in()
{
    $lib = get_instance(); //memanggil library CI
    if (!$lib->session->userdata('id')) {
        redirect('auth');
    } 
}

function check_access($role_id,$menu_id)
{
    $lib = get_instance();

    $lib->db->where('role_id',$role_id);
    $lib->db->where('menu_id',$menu_id);
    $result = $lib->db->get('user_access_menu');
    
    if ($result->num_rows()>0) {
        return "checked='checked'";
    }
}
?>