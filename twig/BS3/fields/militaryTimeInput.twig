{% macro render(field) %}
{% import '@form_config_BS3/fields/textInput.twig' as textInput %}
{{ textInput.render(field) }}
<script type="text/javascript">
    $('#{{ field.id }}').on('change', function(){
        let val = $(this).val();
        if(val.length < 1) {
            return;
        }
        let tid = $(this).val().toString();
        let pm  = false;
        if(tid.length === 1){
            tid = String("0" + tid);
        }

        if(tid.indexOf(' ') > 0) {
            let tmp = tid.split(' ');
            if(tmp.length === 2) {
                tid  = tmp[0];
                pm = (tmp[1].toLowerCase() === 'pm');
            }
        }

        if(tid.indexOf(':') === -1){
            if(tid.length === 3) {
                tid = tid.slice(0,1) + ':' + tid.slice(-2);
            } else if(tid.length === 4) {
                tid = tid.slice(0,2) + ':' + tid.slice(-2);
            } else {
                tid = tid.toString() + ':00';
            }
        }
        if(tid.indexOf(':') === 2){
            tid = tid.toString() + '0';
        }

        if(pm) {
            let tmp = tid.split(':');
            tmp[0]  = parseInt(tmp[0]) + 12;
            tid     = tmp.join(':');
        }

        let tmp = tid.split(':');
        if(tmp[0] > 23) {
            tmp[0] = (tmp[0] % 24);
        }
        if(tmp[1].length > 2) {
            tmp[1] = tmp[1].slice(0,2);
        }

        tid = tmp.join(':');

        $(this).val(tid);
    });
</script>
{% endmacro %}