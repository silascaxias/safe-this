<div class="card">
    <header class="card-header flex-container align-middles space-between">
        <h1>Bem vindo ao Safe This</h1>
    </header>
    <section class="card-content" style="padding-left: 60px;">
        <div class="card-count info">
            <div>
                <i class="fa fa-building"></i>
                <h2 class="count" data-start="0" data-end="<?=$this->model->places;?>">0</h2>
                <h3>Locais Cadastrados</h3>
            </div>
        </div>
        <div class="card-count success">
            <div>
                <i class="fa fa-list"></i>
                <h2 class="count" data-start="0" data-end="<?=$this->model->ocurrences;?>">0</h2>
                <h3>Ocorrências Cadastradas</h3>
            </div>
        </div>
        <div class="card-count danger">
            <div>
                <i class="fa fa-user"></i>
                <h2 class="count" data-start="0" data-end="<?=$this->model->users;?>">0</h2>
                <h3>Usuários Cadastrados</h3>
            </div>
        </div>
    </section>
</div>
<div class="card mg-t-10">
    <header class="card-header flex-container align-middles space-between">
        <h3 class="bolder">Últimas Ocorrências Cadastradas</h3>
    </header>

    <div class="card-content">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Local</th>
                    <th>Status</th>
                    <th>Prioridade</th>
                    <th>Aberto Em</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->model->ocurrencesInfo as $ocurrences): ?>
                <tr>
                    <td><?=$ocurrences['Id']?></td>
                    <td><?=$ocurrences['Description']?></td>
                    <td><?=$ocurrences['Place']?></td>
                    <td>
                        <?foreach ($this->model->update as $update) {
                            if($update['Ocurrence_Id'] == $ocurrences['Id']){
                                foreach ($this->model->status as $status) {
                                    if($update['Ocurrence_Status_Id'] == $status['Ocurrence_Status_Id']){
                                        echo $status['Description'];    
                                        break;  
                                    }
                                }                       
                                break;
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?foreach ($this->model->update as $update) {
                            if($update['Ocurrence_Id'] == $ocurrences['Id']){
                                foreach ($this->model->priorities as $priorities) {
                                    if($update['Ocurrence_Priority_Id'] == $priorities['Ocurrence_Priority_Id']){
                                        echo $priorities['Description'];    
                                        break;  
                                    }
                                }                       
                                break;
                            }
                        }
                        ?>
                    </td>
                    <td><?=date('d/m/Y', strtotime($ocurrences['Opening_Date']));?></td>
                </tr>
                <?php endforeach;?>
        </table>
    </div>
</div>