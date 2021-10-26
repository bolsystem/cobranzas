<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_m extends CI_Model {

  public function get_payments()
  {
    $this->db->select("li.id, c.dni, concat(c.first_name,' ',c.last_name) AS name_cst, l.id AS loan_id, li.pay_date, li.num_quota, li.fee_amount");
    $this->db->from('loan_items li');
    $this->db->join('loans l', 'l.id = li.loan_id', 'left');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->where('li.status', 0);
    $this->db->order_by('li.pay_date', 'desc');

    return $this->db->get()->result(); 
  }

  public function get_searchCst($dni)
  {
    $this->db->select("l.id as loan_id, l.customer_id, c.dni, concat(c.first_name, ' ', c.last_name) AS cst_name, l.credit_amount, l.payment_m, co.name as coin_name");
    $this->db->from('customers c');
    $this->db->join('loans l', 'l.customer_id = c.id', 'left');
    $this->db->join('coins co', 'co.id = l.coin_id', 'left');
    $this->db->where(['c.loan_status' => 1, 'c.dni' => $dni]);

    return $this->db->get()->row(); 
  }

  public function get_quotasCst($loan_id)
  {
    $this->db->where('loan_id', $loan_id);

    $query = $this->db->get('loan_items');
    $data = [];

    foreach ($query->result() as $row) {
      $data[] = [
        '<input type="checkbox" name="quota_id[]" '. ($row->status ? '' : 'disabled checked') . ' data-fee='.$row->fee_amount.' value='.$row->id.'>', 
        $row->num_quota, 
        $row->date, 
        $row->fee_amount, 
        '<button type="button" class="btn btn-sm ' . ($row->status ? 'btn-outline-danger' : 'btn-outline-success') . '">'. ($row->status ? 'Pendiente': 'Pagado') .'</button>',
        ];
    }

    return $data;
  }

  public function update_quota($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('loan_items', $data); 
  }

  public function check_cstLoan($loan_id)
  {
    $this->db->where('loan_id', $loan_id);

    $query = $this->db->get('loan_items'); 

    $check = false;

    foreach ($query->result() as $row) {
      if ($row->status == 1) {
        $check = true;
        break;
      } 
    }

    return $check;
  }

  public function update_cstLoan($loan_id, $customer_id)
  {
    $this->db->where('id', $loan_id);
    $this->db->update('loans', ['status' => 0]);

    $this->db->where('id', $customer_id);
    $this->db->update('customers', ['loan_status' => 0]); 
  }

  public function get_quotasPaid($data)
  {
    $this->db->where_in('id', $data);
    return $this->db->get('loan_items')->result();
  }

}

/* End of file Payments_m.php */
/* Location: ./application/models/Payments_m.php */