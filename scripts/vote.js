document.addEventListener("DOMContentLoaded", () => 
{
    let form = document.querySelector("form")
    let btnSubmit = document.querySelector("#btn-submit")
    let options = document.querySelectorAll("button.options")
    let selectedOption = document.querySelector("#selected-option")
    
    form.onsubmit = e => 
    {
        e.preventDefault()
        return false
    }

    btnSubmit.onclick = _ => 
    {
        if(selectedOption.value == "")
        {
            alert("یک گزینه را انتخاب کنید.")
        }
        else
        {
            form.submit()
        }
    }
    
    options.forEach(btn => 
    {
        btn.onclick = e => 
        {
            options.forEach(btn => 
            {
                btn.classList.remove("selected")
            })

            e.target.classList.add("selected")
            selectedOption.value = e.target.getAttribute("data-id")
        }
    })

})