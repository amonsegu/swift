</main>
    <footer class="page-footer bg-dark text-white text-center p-3">
        &copy; 2020 - SARL SWIFT - Location facile !
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#opentable').DataTable( {
                "language" :{
                                    "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                                    "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                                    "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                                    "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                                    "sInfoPostFix":    "",
                                    "sInfoThousands":  ",",
                                    "sLengthMenu":     "Afficher _MENU_ éléments",
                                    "sLoadingRecords": "Chargement...",
                                    "sProcessing":     "Traitement...",
                                    "sSearch":         "Rechercher :",
                                    "sZeroRecords":    "Aucun élément correspondant trouvé",
                                    "oPaginate": {
                                        "sFirst":    "Premier",
                                        "sLast":     "Dernier",
                                        "sNext":     "Suivant",
                                        "sPrevious": "Précédent"
                                    },
                                    "oAria": {
                                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                                    },
                                    "select": {
                                            "rows": {
                                                "_": "%d lignes sélectionnées",
                                                "0": "Aucune ligne sélectionnée",
                                                "1": "1 ligne sélectionnée"
                                            } 
                                    }
                                }
            });
        });
    </script>
</body>
</html>