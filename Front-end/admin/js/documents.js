function updateDocumentStatus(status) {
    if (!currentDocument) return;

    fetch('../../backend/admin/update_document_status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id: currentDocument.id,
            status: status,
            notes: verificationNotes.value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            currentDocument.status = status;
            showToast(`Document status updated to ${status}`);
            renderDocuments(documents); // Refresh UI
        } else {
            alert('Failed to update status.');
        }
    })
    .catch(error => {
        console.error('Update error:', error);
    });
}
