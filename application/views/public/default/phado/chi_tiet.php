<script>
    var chart_config = {
        chart: {
            container: "#chart-genealogy",
            connectors: {
                type: "step",
                style: {
                    "arrow-end": "block-wide-long",
                    "stroke-width": 1,
                },
            },
            levelSeparation: 40,
        },
        nodeStructure: <?= $processedData; ?>,
    };
</script>
<div class="main__head">
    <a href="#" onclick="goBack()" class="btn-back d-none d-md-flex">Quay lại</a>
    <div class="breadscrum">
        <a href="<?= site_url('/gia-pha/pha-do') ?>" class="breadscrum__link">Phả đồ</a>
        <span><?= $person_info->full_name ?></span>
    </div>
</div>
<div class="content">
    <div class="panel post">
        <div class="resume">
            <div class="resume__head">
                <div class="resume__avatar">
                    <?= getImage($person_info->thumbnail); ?>
                </div>
                <div class="resume__info">
                    <h2>Thông tin thành viên</h2>
                    <div class="dataset">
                        <dl>
                            <dt>Đời thứ</dt>
                            <dd><?= $person_info->parent_id ?></dd>
                        </dl>
                        <dl>
                            <dt>Tên húy</dt>
                            <dd><?= $person_info->full_name ?></dd>
                        </dl>
                        <dl>
                            <dt>Giới tính</dt>
                            <dd><?= $person_info->gender ?></dd>
                        </dl>
                        <dl>
                            <dt>Công việc</dt>
                            <dd><?= !empty($person_info->job_title) ? $person_info->job_title : 'Chưa rõ'; ?></dd>
                        </dl>
                        <dl>
                            <dt>Tình trạng</dt>
                            <dd><?= $person_info->status ?></dd>
                        </dl>
                        <dl>
                            <dt>Ngày sinh</dt>
                            <dd><?= date("d/m/Y", strtotime($person_info->birth_date)) ?></dd>
                        </dl>
                        <?php if ($person_info->status == 'Mất' && $person_info->date_die != '0000-00-00'): ?>
                            <dl>
                                <dt>Ngày mất</dt>
                                <dd><?= date("d/m/Y", strtotime($person_info->date_die)); ?></dd>
                            </dl>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="resume__desc">
                <h2>Phả ký</h2>
                <?= $person_info->description ?>
            </div>
        </div>
    </div>
    <div class="chart chart--mini" id="chart--mini">
        <div class="chart__title">
            Sơ đồ gia phả
            <span>(3 đời)</span>
        </div>
        <div class="chart__content" id="chart-genealogy"></div>
        <div class="legend">
            <div class="legend__title">CHÚ THÍCH</div>
            <div class="legend__list">
                <ul>
                    <li>
                        <span class="label label--text label--origin"></span>Chồng
                    </li>
                    <li>
                        <span class="label label--text label--partner"></span>Vợ
                    </li>
                    <li>
                        <span class="label label--bg label--male"></span>Con
                        trai
                    </li>
                    <li>
                        <span class="label label--bg label--female"></span>Con
                        gái
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="resume">
        <div class="resume__detail">
            <ul>
                <li>
                    <h3>Bố mẹ</h3>
                    <div class="panel">
                        <div class="table">
                            <table>
                                <colgroup>
                                    <col />
                                    <col />
                                    <col />
                                    <col />
                                    <col />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="d-pc">Số thứ tự</span>
                                            <span class="d-sp">STT</span>
                                        </th>
                                        <th>Họ tên</th>
                                        <th>Ngày sinh</th>
                                        <th>Trạng thái</th>
                                        <th>Quan hệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php if (!empty($father)): ?>
                                            <tr>
                                                <td>1</td>
                                                <td><?= $father->full_name ?? 'Chưa rõ' ?></td>
                                                <td><?= !empty($father->birth_date) && strtotime($father->birth_date) !== false ? date("d/m/Y", strtotime($father->birth_date)) : 'Chưa rõ' ?></td>
                                                <td><?= $father->status ?? 'Chưa rõ' ?></td>
                                                <td><?= ($father->gender == 'Nam') ? 'Bố' : 'Mẹ'; ?></td>
                                            </tr>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="5">Đang cập nhật dữ liệu</td>
                                        </tr>
                                    <?php endif; ?>
                                        <?php if (!empty($mother)): ?>
                                            <tr>
                                                <td>2</td>
                                                <td><?= $mother->full_name ?? 'Chưa rõ' ?></td>
                                                <td><?= !empty($mother->birth_date) && strtotime($mother->birth_date) !== false ? date("d/m/Y", strtotime($mother->birth_date)) : 'Chưa rõ' ?></td>
                                                <td><?= $mother->status ?? 'Chưa rõ' ?></td>
                                                <td><?= ($mother->gender == 'Nam') ? 'Bố' : 'Mẹ'; ?></td>
                                            </tr>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="5">Đang cập nhật dữ liệu</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <h3>Danh sách anh/chị/em ruột</h3>
                    <div class="panel">
                        <div class="table">
                            <table>
                                <colgroup>
                                    <col />
                                    <col />
                                    <col />
                                    <col />
                                    <col />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="d-pc">Số thứ tự</span>
                                            <span class="d-sp">STT</span>
                                        </th>
                                        <th>Họ tên</th>
                                        <th>Ngày sinh</th>
                                        <th>Trạng thái</th>
                                        <th>Quan hệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($list_data['list_sibling'])): ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($list_data['list_sibling'] as $item): if ($item['id'] == $id || $item['role'] == 'Vợ') continue; ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= !empty($item['full_name']) ? $item['full_name'] : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['birth_date']) && strtotime($item['birth_date']) !== false ? date("d/m/Y", strtotime($item['birth_date'])) : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['status']) ? $item['status'] : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['role']) ? $item['role'] : 'Chưa rõ' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (count($list_data['list_sibling']) == 0 || $i == 1): ?>
                                            <tr>
                                                <td colspan="5">Đang cập nhật dữ liệu</td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">Đang cập nhật dữ liệu</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <h3>Danh sách vợ</h3>
                    <div class="panel">
                        <div class="table">
                            <table>
                                <colgroup>
                                    <col />
                                    <col />
                                    <col />
                                    <col />
                                    <col />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="d-pc">Số thứ tự</span>
                                            <span class="d-sp">STT</span>
                                        </th>
                                        <th>Họ tên</th>
                                        <th>Ngày sinh</th>
                                        <th>Trạng thái</th>
                                        <th>Quan hệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($list_data)): ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($list_data['list_wife'] as $item): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= !empty($item['full_name']) ? $item['full_name'] : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['birth_date']) && strtotime($item['birth_date']) !== false ? date("d/m/Y", strtotime($item['birth_date'])) : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['status']) ? $item['status'] : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['role']) ? $item['role'] : 'Chưa rõ' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (count($list_data['list_wife']) == 0): ?>
                                            <tr>
                                                <td colspan="5">Đang cập nhật dữ liệu</td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">Đang cập nhật dữ liệu</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                    <h3>Danh sách con cái</h3>
                    <div class="panel">
                        <div class="table">
                            <table>
                                <colgroup>
                                    <col />
                                    <col />
                                    <col />
                                    <col />
                                    <col />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="d-pc">Số thứ tự</span>
                                            <span class="d-sp">STT</span>
                                        </th>
                                        <th>Họ tên</th>
                                        <th>Ngày sinh</th>
                                        <th>Trạng thái</th>
                                        <th>Giới tính</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($list_data)): ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($list_data['list_child'] as $item): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= !empty($item['full_name']) ? $item['full_name'] : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['birth_date']) && strtotime($item['birth_date']) !== false ? date("d/m/Y", strtotime($item['birth_date'])) : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['status']) ? $item['status'] : 'Chưa rõ' ?></td>
                                                <td><?= !empty($item['gender']) ? $item['gender'] : 'Chưa rõ' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (count($list_data['list_child']) == 0): ?>
                                            <tr>
                                                <td colspan="5">Đang cập nhật dữ liệu</td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">Đang cập nhật dữ liệu</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php $this->load->view($this->template_path . 'block/xuat_pdf'); ?>
</div>