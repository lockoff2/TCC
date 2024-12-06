let questaoIndex = 0;

function adicionarQuestao() {
    const container = document.getElementById('questoes-container');
    const novaQuestao = document.createElement('div');
    novaQuestao.classList.add('questao');
    novaQuestao.innerHTML = `
        <hr>
        <div class="mb-3">
            <label class="form-label">Título da Questão</label>
            <input type="text" name="questoes[${questaoIndex}][titulo]" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="questoes[${questaoIndex}][descricao]" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="questoes[${questaoIndex}][tipo]" class="form-select" required onchange="toggleAlternativas(this, ${questaoIndex})">
                <option value="" disabled selected>Escolha o tipo da questão</option>
                <option value="1">Objetiva</option>
                <option value="2">Verdadeiro/Falso</option>
            </select>
        </div>
        <div id="alternativas-${questaoIndex}" style="display: none;"></div>
    `;
    container.appendChild(novaQuestao);
    questaoIndex++;
}

function toggleAlternativas(select, questaoIndex) {
    const alternativasDiv = document.getElementById(`alternativas-${questaoIndex}`);
    alternativasDiv.innerHTML = ""; // Limpa as alternativas ao trocar o tipo da questão

    if (select.value == "1") {
        // Para tipo "Objetiva", cria exatamente 5 alternativas
        alternativasDiv.style.display = "block";
        alternativasDiv.innerHTML = `
            <h5>Alternativas</h5>
            ${[...Array(5).keys()]
                .map(
                    (i) => `
                    <div class="mb-3">
                        <label class="form-label">Alternativa ${i + 1}</label>
                        <input type="text" name="questoes[${questaoIndex}][alternativas][${i}][conteudo]" class="form-control" required>
                        <input type="radio" name="questoes[${questaoIndex}][correta]" value="${i}" required> Correta
                    </div>
                `
                )
                .join("")}
        `;
    } else if (select.value == "2") {
        // Para tipo "Verdadeiro/Falso", exibe automaticamente as opções fixas
        alternativasDiv.style.display = "block";
        alternativasDiv.innerHTML = `
            <h5>Alternativas</h5>
            <div class="mb-3">
                <label class="form-label">Verdadeiro</label>
                <input type="radio" name="questoes[${questaoIndex}][correta]" value="true" required> Correta
            </div>
            <div class="mb-3">
                <label class="form-label">Falso</label>
                <input type="radio" name="questoes[${questaoIndex}][correta]" value="false" required> Correta
            </div>
        `;
    } else {
        alternativasDiv.style.display = "none"; // Oculta para tipos não tratados
    }
}
