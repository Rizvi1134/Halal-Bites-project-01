function calculateTotal() {
    let total = 0;

    document.querySelectorAll(".menu-item").forEach(item => {
        let price = parseFloat(item.getAttribute("data-price"));
        let qty = item.querySelector("input").value;

        total += price * qty;
    });

    let discount = 0;

    if (total >= 1000) {
        discount = Math.floor(total / 1000) * 0.10 * total;
    }

    let final = total - discount;

    document.getElementById("total").innerText = total + " Tk";
    document.getElementById("discount").innerText = discount.toFixed(2) + " Tk";
    document.getElementById("final").innerText = final.toFixed(2) + " Tk";
}