<script type="text/javascript" src="<?php echo base_url("assets/js/plugins/notifications/pnotify.min.js")?>"></script>
<script type="text/javascript">
<?php if($this->session->flashdata('success')){ ?>
    // toastr.success("<?php echo $this->session->flashdata('success'); ?>");
    new PNotify({
            title: 'Success notice',
            text: '<?php echo $this->session->flashdata('success'); ?>',
            addclass: 'alert alert-styled-right bg-success alert-styled-custom alert-arrow-left',
            hide: true,
            delay: 3000,
            remove: true,
            destroy: true,
        });
<?php }else if($this->session->flashdata('error')){  ?>
    // toastr.error("<?php echo $this->session->flashdata('error'); ?>");
    new PNotify({
            title: 'Error notice',
            text: '<?php echo $this->session->flashdata('error'); ?>',
            addclass: 'alert alert-styled-right bg-danger alert-styled-custom alert-arrow-left',
            hide: true,
            delay: 3000,
            remove: true,
            destroy: true,
        });
<?php }else if($this->session->flashdata('warning')){  ?>
    // toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
    new PNotify({
            title: 'Warning notice',
            text: '<?php echo $this->session->flashdata('warning'); ?>',
            addclass: 'alert alert-styled-right bg-warning alert-styled-custom alert-arrow-left',
            hide: true,
            delay: 3000,
            remove: true,
            destroy: true,
        });
<?php }else if($this->session->flashdata('info')){  ?>
    // toastr.info("<?php echo $this->session->flashdata('info'); ?>");
    new PNotify({
            title: 'Info notice',
            text: '<?php echo $this->session->flashdata('info'); ?>',
            addclass: 'alert alert-styled-right bg-info alert-styled-custom alert-arrow-left',
            hide: true,
            delay: 3000,
            remove: true,
            destroy: true,
        });
<?php } ?>


</script>