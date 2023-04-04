import React from "react";
import { Modal, Button } from "react-bootstrap";

function RGPD(props) {
  return (
    <Modal show={props.showModal} onHide={props.onHide}>
      <Modal.Header closeButton>
        <Modal.Title>{props.title}</Modal.Title>
      </Modal.Header>
      <Modal.Body>{props.children}</Modal.Body>
      <Modal.Footer>
        <Button variant="secondary" onClick={props.onHide} >
          Fermer
        </Button>
      </Modal.Footer>
    </Modal>
  );
}

export default RGPD;
