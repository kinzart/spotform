
$(document).ready(function() {
            
    // Função para fechar o modal
    function closePopup() {
               $("#modal").hide();
           }

           $("#form-spot").submit(function(e) {
               e.preventDefault(); // Impede o envio padrão do formulário

               $.ajax({
                   url: "processar_formulario.php", // Altere para o URL do seu script PHP
                   type: "POST",
                   data: $(this).serialize(),
                   success: function(response) {
                       $("#modal").show(); 
                       $("#last-section").show(); // Exibe a sessão
                       $("html, body").animate({
                           scrollTop: $("#last-section").offset().top // Rola a página até a sessão
                       }, 1000); // Tempo de animação em milissegundos
                       $("#form-spot :input").prop("disabled", true);
                       $("#mensagem").html(response); // Exibe a mensagem de sucesso ou erro
                   },
                   error: function(error) {
                       console.log(error);
                   }
               });
           });
           $("#close-modal").click(closePopup);
           $("#ler-rider").click(closePopup);
       });
     