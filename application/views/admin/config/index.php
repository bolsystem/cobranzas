<div class="card shadow mb-4">
  <div class="card-header py-3">Editar datos usuario</div>
  <div class="card-body">
    <?php if ($this->session->flashdata('msg')): ?>
      <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= $this->session->flashdata('msg') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif ?>
    <?php if(validation_errors()) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo validation_errors('<li>', '</li>'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>
    <?php echo form_open(); ?>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label class="small mb-1" for="inputUsername">Ingresar Nombre</label>
          <input class="form-control" id="inputUsername" type="text" name="first_name" value="<?php echo set_value('first_name', $this->input->post('first_name') ? $this->input->post('first_name') : $user->first_name); ?>">
        </div>
        <div class="form-group col-md-4">
          <label class="small mb-1" for="exampleFormControlTextarea1">Ingresar Apellidos</label>
          <input class="form-control" id="inputUsername" type="text" name="last_name" value="<?php echo set_value('last_name', $this->input->post('last_name') ? $this->input->post('last_name') : $user->last_name); ?>">
        </div>
        <div class="form-group col-md-4">
          <label class="small mb-1" for="exampleFormControlTextarea1">Ingresar correo</label>
          <input class="form-control" id="inputUsername" type="email" name="email" value="<?php echo set_value('email', $this->input->post('email') ? $this->input->post('email') : $user->email); ?>">
        </div>
      </div>
      <button class="btn btn-primary" type="submit">Editar datos</button>
      <a href="<?php echo site_url('admin/dashboard/'); ?>" class="btn btn-dark">Cancelar</a>
    <?php echo form_close() ?>
  </div>
</div>