
document.getElementById("orcamento_final").addEventListener("input", function() {
    var valorInserido = parseInt(this.value);

    if (isNaN(valorInserido)) {
        // Se o valor inserido não for um número, exibe uma mensagem de erro
        this.setCustomValidity("Insira um número válido.");
    } else if (valorInserido < 100 || valorInserido > 2000) {
        // Se o valor inserido estiver fora do intervalo desejado, exibe uma mensagem de erro
        this.setCustomValidity("O valor deve estar entre 100 e 2000.");
    } else {
        // Se o valor estiver dentro do intervalo, não há erro
        this.setCustomValidity("");
    }
});


$(document).ready(function() {
    // Função para fechar o modal
    function closePopup() {
        $("#modal").hide();
    }

    $("#form-spot").submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        var formData = new FormData(this);
   // Adicione as imagens ao FormData corretamente
   var imageInputs = document.querySelectorAll('input[type="file"]');
   for (var i = 0; i < imageInputs.length; i++) {
       var fileInput = imageInputs[i];
       var files = fileInput.files;
       for (var j = 0; j < files.length; j++) {
           formData.append('fotos_divulgacao[]', files[j]);
       }
   }

   console.log(formData);
   
        $.ajax({
            url: "processar_formulario.php", // Altere para o URL do seu script PHP
            type: "POST",
            data: formData,
            processData: false,  // Evita o processamento automático dos dados
            contentType: false,  // Evita o cabeçalho "Content-Type" padrão
            success: function(response) {
                if (response.success) {
                    // Sucesso - exibir mensagem de sucesso para o usuário
                    $("#modal").show();
                    $("#last-section").show();
                    $("html, body").animate({
                        scrollTop: $("#last-section").offset().top
                    }, 1000);
                    $("#form-spot :input").prop("disabled", true);
                    $("#mensagem").html(response.message); // Exibe a mensagem de sucesso
                    console.log("Formulário enviado com sucesso");
                } else {
                    // Erro - exibir mensagem de erro para o usuário
                    $("#mensagem").html(response.message); // Exibe a mensagem de erro
                    if (response.errors && response.errors.length > 0) {
                        // Se houver detalhes de erros, exiba-os
                        var errorList = "<ul>";
                        for (var i = 0; i < response.errors.length; i++) {
                            errorList += "<li>" + response.errors[i] + "</li>";
                        }
                        errorList += "</ul>";
                        $("#mensagem").append(errorList);
                    }
                }
            },
        
            error: function(error) {
                console.log(error);
            }
            
        });
    },
       
    $("#close-modal").click(closePopup);
    $("#ler-rider").click(closePopup);
});
