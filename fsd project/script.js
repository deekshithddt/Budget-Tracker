document.addEventListener("DOMContentLoaded", function () {
    const transactionForm = document.getElementById("transaction-form");
    const transactionList = document.getElementById("transaction-list");
    const balanceDisplay = document.getElementById("balance");

    let transactions = [];

    transactionForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const description = document.getElementById("description").value;
        const amount = parseFloat(document.getElementById("amount").value);
        const type = document.getElementById("type").value;

        if (!description || isNaN(amount) || amount <= 0) {
            alert("Please enter a valid description and amount.");
            return;
        }

        // Send data to PHP via fetch
        const formData = new FormData();
        formData.append("description", description);
        formData.append("amount", amount);
        formData.append("type", type);

        fetch("add_transaction.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log("PHP Response:", data);

            // Push to local list for display
            transactions.push({ description, amount, type });
            updateTransactionsUI();
            updateBalance();
            transactionForm.reset();
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Failed to save transaction.");
        });
    });

    function updateTransactionsUI() {
        transactionList.innerHTML = "";

        transactions.forEach((transaction, index) => {
            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");

            const sign = transaction.type === "income" ? "+" : "-";
            listItem.innerHTML = `
                ${transaction.description} 
                <span class="${transaction.type}">${sign}₹${Math.abs(transaction.amount).toFixed(2)}</span>
                <button class="btn btn-danger btn-sm ml-2 delete-btn" data-index="${index}">&times;</button>
            `;

            transactionList.appendChild(listItem);
        });

        document.querySelectorAll(".delete-btn").forEach((btn) => {
            btn.addEventListener("click", function () {
                deleteTransaction(this.dataset.index);
            });
        });
    }

    function updateBalance() {
        const balance = transactions.reduce((acc, transaction) => {
            return transaction.type === "income" ? acc + transaction.amount : acc - transaction.amount;
        }, 0);

        balanceDisplay.textContent = `₹${balance.toFixed(2)}`;
    }

    function deleteTransaction(index) {
        transactions.splice(index, 1);
        updateTransactionsUI();
        updateBalance();
    }

    document.querySelectorAll("a.nav-link").forEach((anchor) => {
        anchor.addEventListener("click", function (event) {
            if (this.getAttribute("href").startsWith("#")) {
                event.preventDefault();
                const targetId = this.getAttribute("href").substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 50,
                        behavior: "smooth",
                    });
                }
            }
        });
    });
});
