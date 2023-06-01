document.addEventListener("DOMContentLoaded", () => 
{
    let forms = document.querySelectorAll("form")
    let btnOptionRemove = document.querySelectorAll("button.option-remove")
    let btnOptionAdd = document.querySelector("#btn-add-option")
    let btnSubmitCreate = document.querySelector("#btn-submit-create")
    let btnSubmitUpdate = document.querySelector("#btn-submit-update")
    let btnSubmitDelete = document.querySelector("#btn-submit-delete")

    forms.forEach(form => 
    {
        form.onsubmit = e =>
        {
            e.preventDefault()
            return false
        }
    })
    
    btnOptionRemove.forEach(btn => 
    {
        btn.onclick = e => 
        {
            e.target.parentNode.style.display = "none"
            let hidden = e.target.parentNode.children[2]
            hidden.value = -parseInt(hidden.value)
        }

        btn.children[0].onclick = e => 
        {
            e.target.parentNode.parentNode.style.display = "none"
            let hidden = e.target.parentNode.parentNode.children[2]
            hidden.value = -parseInt(hidden.value)
        }
    })

    btnOptionAdd.onclick = e => 
    {
        /* html template :
        <div class="f-item split">
            <input type="text" name="s_options[]" class="survay-option" required />
            <button class="option-remove"> <i class="fa fa-remove"></i> </button>
            <input type="hidden" name="s_options_id[]" value="999999999" /> // inside form_update.php
        </div> */

        let i = document.createElement("i")
        i.className = "fa fa-remove"
        i.onclick = e => 
        {
            e.target.parentNode.parentNode.remove()
        }

        let button = document.createElement("button")
        button.className = "option-remove"
        button.appendChild(i)
        button.onclick = e => 
        {
            e.target.parentNode.remove()
        }

        let input =  document.createElement("input")
        input.type = "text"
        input.required = "required"
        input.name = "s_options[]"
        input.className = "survay-option"

        let div = document.createElement("div")
        div.className = "f-item split"
        div.appendChild(input)
        div.appendChild(button)

        if( e.target.hasAttribute("data-mode-update") ) 
        {
            let hidden =  document.createElement("input")
            hidden.type = "hidden"
            hidden.required = "required"
            hidden.name = "s_options_id[]"
            hidden.value = "+"
            div.appendChild(hidden)
        }

        document.querySelector("#survay-options").appendChild(div)
    }
    

    if(btnSubmitCreate != null) 
    {
        btnSubmitCreate.onclick = _ => 
        {
            let remail = /\S+@\S+\.\S+/
            let author = document.querySelector("input[name='s_creator']").value.length > 2
            let email = document.querySelector("input[name='s_email']").value.length > 5 && remail.test(document.querySelector("input[name='s_email']").value)
            let question = document.querySelector("input[name='s_question']").value.length > 7
            let options = true

            document.querySelectorAll(".survay-option").forEach(input => 
            {
                if(input.value == "")
                {
                    options = false
                }
            })
    
            if(author && email && question && options)
            {
                document.querySelector("#form-survay-create").submit()
            }
            else
            {
                alert("همه ورودی ها را پر کنید.")
            }
        }
    }
    
    if(btnSubmitUpdate != null) 
    {
        btnSubmitUpdate.onclick = _ => 
        {
            let question = document.querySelector("input[name='s_question']").value.length > 7
            let options = true
            document.querySelectorAll(".survay-option").forEach(input => {
                if(input.value == "")
                    options = false
            })
    
            if(question && options)
            {
                document.querySelector("#form-survay-update").submit()
            }
            else
            {
                alert("همه ورودی ها را پر کنید.")
            }
        }
    }
    
    if(btnSubmitDelete != null) 
    {
        btnSubmitDelete.onclick = _ => 
        {
            let doDelete = confirm("آیا از حذف این نظر سنجی مطمعن هستید ؟ با این کار تمام آمار آن هم حذف می شود ؟")

            if(doDelete) 
            {
                document.querySelector("#form-survay-delete").submit()
            }
        }
    }
    
})