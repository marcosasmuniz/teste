document.addEventListener('DOMContentLoaded', () => {
    const API_BASE_URL = '/whatsapp_billing_system/public/index.php/api'; // Adjusted to include index.php if not using URL rewriting

    // --- Customer Management (customers.html) ---
    const customerListTableBody = document.getElementById('customer-list-table-body');
    const addCustomerForm = document.getElementById('add-customer-form');
    const addCustomerBtn = document.getElementById('add-customer-btn'); // Corrected ID based on HTML

    function fetchCustomers() {
        if (!customerListTableBody) return;
        console.log('Fetching customers...');

        // Simulate API call as GET /api/customers for listing is not explicitly defined
        // In a real scenario, this would be: fetch(`${API_BASE_URL}/customers`)
        const dummyCustomers = [
            { id: '1', name: 'Alice Wonderland', email: 'alice@example.com', whatsapp_number: '5511987654321', cpf_cnpj: '111.222.333-44' },
            { id: '2', name: 'Bob The Builder', email: 'bob@example.com', whatsapp_number: '5521912345678', cpf_cnpj: '12.345.678/0001-99' }
        ];

        customerListTableBody.innerHTML = ''; // Clear existing rows
        dummyCustomers.forEach(customer => {
            const row = customerListTableBody.insertRow();
            row.innerHTML = `
                <td>${customer.name}</td>
                <td>${customer.email}</td>
                <td>${customer.whatsapp_number}</td>
                <td>${customer.cpf_cnpj || ''}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="alert('View customer ${customer.id}')">View</button>
                    <button class="btn btn-sm btn-warning" onclick="alert('Edit customer ${customer.id}')">Edit</button>
                </td>
            `;
        });
        console.log('Customer list populated (simulated).');
    }

    if (addCustomerForm) {
        addCustomerForm.addEventListener('submit', (event) => {
            event.preventDefault();
            console.log('Add customer form submitted.');

            const name = document.getElementById('customer-name').value;
            const email = document.getElementById('customer-email').value;
            const whatsapp_number = document.getElementById('customer-whatsapp').value;
            const cpf_cnpj = document.getElementById('customer-cpf_cnpj').value;

            const customerData = { name, email, whatsapp_number, cpf_cnpj };

            fetch(`${API_BASE_URL}/customers`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(customerData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Add customer response:', data);
                alert(data.message || 'Customer operation feedback.');
                if (data.message && data.message.includes('placeholder')) { // Assuming success from placeholder
                    fetchCustomers(); // Refresh customer list
                    addCustomerForm.reset();
                }
            })
            .catch(error => {
                console.error('Error adding customer:', error);
                alert('Error adding customer. See console for details.');
            });
        });
    }

    if (customerListTableBody) { // If on customers.html
        fetchCustomers();
    }

    // --- Invoice Viewing (invoices.html) ---
    const customerSelectForInvoices = document.getElementById('customer-select-for-invoices');
    const invoiceListTableBody = document.getElementById('invoice-list-table-body');

    function populateCustomerSelect() {
        if (!customerSelectForInvoices) return;
        console.log('Populating customer select...');

        // Simulate API call as GET /api/customers for listing is not explicitly defined
        const dummyCustomers = [
            { id: 'cust_1', name: 'Alice Wonderland (ID: cust_1)' },
            { id: 'cust_2', name: 'Bob The Builder (ID: cust_2)' },
            { id: 'sim_cust_123', name: 'Simulated Customer (ID: sim_cust_123)'}
        ];

        dummyCustomers.forEach(customer => {
            const option = document.createElement('option');
            option.value = customer.id; // Use a unique ID, e.g., Asaas customer ID
            option.textContent = customer.name;
            customerSelectForInvoices.appendChild(option);
        });
        console.log('Customer select populated (simulated).');
    }

    if (customerSelectForInvoices) {
        populateCustomerSelect();

        customerSelectForInvoices.addEventListener('change', () => {
            const customerId = customerSelectForInvoices.value;
            if (!customerId || customerId === "Select a customer...") {
                invoiceListTableBody.innerHTML = ''; // Clear table if no customer selected
                return;
            }
            console.log(`Fetching invoices for customer ID: ${customerId}`);

            // Simulate API call, as backend returns basic placeholder
            // Real: fetch(`${API_BASE_URL}/invoices?customer_id=${customerId}`)
            const dummyInvoices = [
                { id: 'inv_A1', due_date: '2024-08-15', amount: 100.50, status: 'PENDING', payment_link: 'http://example.com/pay/A1' },
                { id: 'inv_A2', due_date: '2024-07-20', amount: 75.00, status: 'PAID', payment_link: 'http://example.com/pay/A2' },
            ];
            const otherCustomerInvoices = [
                 { id: 'inv_B1', due_date: '2024-09-01', amount: 250.00, status: 'OVERDUE', payment_link: 'http://example.com/pay/B1' },
            ];

            const invoicesToDisplay = customerId === 'cust_1' ? dummyInvoices : (customerId === 'cust_2' ? otherCustomerInvoices : []);


            invoiceListTableBody.innerHTML = ''; // Clear existing rows
            if (invoicesToDisplay.length > 0) {
                invoicesToDisplay.forEach(invoice => {
                    const row = invoiceListTableBody.insertRow();
                    row.innerHTML = `
                        <td>${invoice.id}</td>
                        <td>${invoice.due_date}</td>
                        <td>${invoice.amount.toFixed(2)}</td>
                        <td>${invoice.status}</td>
                        <td><a href="${invoice.payment_link}" target="_blank">Link</a></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="alert('View invoice ${invoice.id}')">Details</button>
                        </td>
                    `;
                });
            } else {
                 const row = invoiceListTableBody.insertRow();
                 row.innerHTML = `<td colspan="6">No invoices found for this customer (simulated).</td>`;
            }
            console.log('Invoice list populated (simulated).');
        });
    }

    // --- Send Message (send_message.html) ---
    const sendManualMessageForm = document.getElementById('send-manual-message-form');
    const sendMessageBtn = document.getElementById('send-message-btn'); // Corrected ID

    if (sendManualMessageForm) { // Check if the form exists
        sendManualMessageForm.addEventListener('submit', (event) => {
            event.preventDefault();
            console.log('Send message form submitted.');

            const recipient = document.getElementById('message-recipient').value;
            const body = document.getElementById('message-body').value;

            const messageData = { recipient_whatsapp_number: recipient, message_body: body };

            fetch(`${API_BASE_URL}/messages/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(messageData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Send message response:', data);
                alert(data.message || 'Message operation feedback.');
                if (data.message && data.message.includes('placeholder')) { // Assuming success from placeholder
                     sendManualMessageForm.reset();
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Error sending message. See console for details.');
            });
        });
    }
});
