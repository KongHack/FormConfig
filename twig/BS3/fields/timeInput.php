{% macro render(field) %}
{% import '@form_config_BS3/fields/textInput.twig' as textInput %}
{{ textInput.render(field) }}
<script type="text/javascript">
    $('#{{ field.id }}').on('change', function(){
        let val = (typeof($(this).val()) != undefined && $(this).val() != '' ? $(this).val().trim():false);
        let fullExp = /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;
        let hoursExp = /^([0-9]|0[0-9]|1[0-9]|2[0-3])/;
        let minutesExp = /^[0-5][0-9]$/;
        let hours = '';
        let minutes = '';

        if(val !== false){
            //something is in the val.
            if(hoursExp.test(val) && !fullExp.test(val)){
                //add this bit- the next part may explode it away, or it may be fixed and move on.
                val += ':00';

                if(!fullExp.test(val)){
                    //if a colon is in it somewhere
                    if(val.indexOf(':') > 0){
                        let valArgs = val.split(':');
                        if(hoursExp.test(valArgs[0])){
                            hours = valArgs[0];
                        }

                        if(hours > 23){
                            $(this).val('');
                            return false;
                        }

                        let tempMinutes = valArgs[1].substring(0,2).padEnd(2,0);

                        if(minutesExp.test(tempMinutes)){
                            minutes = tempMinutes;
                        }

                        let tempTime = hours + ':' + minutes;
                        if(fullExp.test(tempTime)){
                            val = tempTime;
                            $(this).val(val);
                        }
                    }
                } else {
                    $(this).val(val);
                }
            }

            if($this)

        }
    });
</script>
{% endmacro %}