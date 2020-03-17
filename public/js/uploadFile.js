document.querySelector('form').addEventListener('submit',async function(event){
    var form = this
    var fileField = this.querySelector('input[type="file"]');
    if(!fileField) { return; }

    event.preventDefault();
    var formData = new FormData();
    var formImputs = JSON.parse(form.dataset.inputs);

    for(var key in formImputs)
    {
        formData.append(key,formImputs[key]);
    }

    formData.append('file', fileField.files[0]);


    const formAttributes = JSON.parse(form.dataset.attributes);
    var isOK = await StoreImage(formAttributes, formData);
    if(isOK)
    {
        fileField.remove();
        form.submit();
    }
});

async function StoreImage(formAttributes, formData)
{
    var response = await fetch(formAttributes.action, {
        method: formAttributes.method, // or 'PUT'
        headers: {
            //  'Content-Type': formAttributes.enctype,
        },
        body: formData,
    });

    return response;
}
