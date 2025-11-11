<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reviews extends Public_Controller
{

    protected $_reviews;
    protected $_order;

    public function __construct()
    {
        parent::__construct();
        //tải model
        $this->load->model(['reviews_model','order_model']);
        $this->_reviews = new Reviews_model();
        $this->_order = new Order_model();

    }

    public function vote()
    {
        $this->_validation();
        $data = $this->input->post();
            $ip = $this->input->ip_address();
            $check_review_exits = $this->_reviews->checkExitsReviews(
              [
                'ip' => $ip,
                'product_id' => $data['product_id']
              ]
            );
            if (empty($check_review_exits)) {
                $data['ip'] = $ip;
                $data['is_status'] = 1;
                if(empty($data['rate']) && !is_int($data['rate'])) $data['rate'] = 5;
                if ($this->_reviews->insert($data)) {
                    $message['type'] = 'success';
                    $message['message'] = 'Ketsatgiadinh.vn đã nhận được đánh giá của bạn, Cảm ơn bạn đã tin tưởng và lựa chọn sản phẩm của Shop. <br/>Chúc bạn có thật nhiều sức khỏe. Tiếp tục ủng hộ chúng mình trong những lần tới nha.';
                } else {
                    $message['type'] = 'error';
                    $message['message'] = 'Có lỗi xảy ra';
                }
            } else {
                $message['type'] = 'warning';
                $message['message'] = 'Bạn đã đánh giá cho sản phẩm này rồi !!';
            }

        $this->returnJson($message);
    }

    private function _validation()
    {
        $this->checkRequestPostAjax();
        $rules = [
          [
            'field' => "name",
            'label' => "Name",
            'rules' => "required|trim"
          ],
          [
            'field' => "email",
            'label' => "Email",
            'rules' => "required|valid_email"
          ],
          [
            'field' => "rate",
            'label' => "Đánh giá",
            'rules' => "required|trim"
          ],
          [
            'field' => "content",
            'label' => "Bình luận",
            'rules' => "required"
          ]
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $message['type'] = "warning";
            $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
            $valid = array();
            if (!empty($rules)) {
                foreach ($rules as $item) {
                    if (!empty(form_error($item['field']))) {
                        $valid[$item['field']] = form_error($item['field']);
                    }
                }
            }
            $message['validation'] = $valid;
            $this->returnJson($message);
        }
    }

    public function ajax_vote()
    {
        $this->checkRequestPostAjax();
        $data = $this->input->post();
        $ip = $this->input->ip_address();
        $exits = $this->_reviews->checkExitsReviews([
          'ip' => $ip,
          'slug' => $data['url']
        ]);

        if ($exits) {
            $message['type'] = 'warning';
            $message['message'] = 'Bạn đã đánh giá cho bài viết rồi';
        } else {
            $params = [
              'slug' => str_replace(base_url(), "", $data['url']),
              'rate' => $data['rate'],
              'ip' => $ip,
            ];
            if ($this->_reviews->save($params, $this->_reviews->table)) {
                $message['type'] = 'success';
                $message['message'] = 'Bạn đã vote ' . $data['rate'] . ' sao cho bài viết !!';
            } else {
                $message['error'] = 'error';
                $message['message'] = 'Có lỗi xảy ra';
            }
        }
        $rate = $this->_reviews->getRate(
          [
            'slug' => $data['url']
          ]
        );
        $message['vote']['avg'] = $rate->avg;
        $message['vote']['count'] = $rate->count_vote;
        $this->returnJson($message);
    }

    public function validdate_phone()
    {
        $phone = $this->input->post('reviews_phone');
        $count_phone = strlen($phone);
        if (preg_match('/((09|03|07|08|05)+([0-9]{8})\b)/iu', $phone)) {
            if (empty($phone)) {
                $this->form_validation->set_message('validdate_phone', 'Trường số điện thoại không được để trống');
                return false;
            } elseif ($count_phone < 7 || $count_phone > 10) {
                $this->form_validation->set_message('validdate_phone', 'Trường số điện thoại không hợp lệ');
                return false;
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('validdate_phone', 'Trường số điện thoại không hợp lệ');
            return false;
        }
    }


}
