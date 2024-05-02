
        <!--JavaScript at end of body for optimized loading-->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"
                integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
                crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

        <script>

            //Materialize loads
            window.addEventListener('load', function() {
                $('select').formSelect();
                $('.sidenav').sidenav();
                $('.modal').modal();
            });

        </script>

        <script>

            function showToastMsg(msg, color = 'red'){
                M.toast({html: msg, displayLength: 4000, classes: color})
            }

            if (contentToastMsg != ""){

                //showToastMsg(contentToastMsg);

                if (contentToastMsgColor == "")
                    contentToastMsgColor = 'red';

                showToastMsg(contentToastMsg, contentToastMsgColor);
            }

        </script>

        @yield('scripts')

    </body>
</html>
