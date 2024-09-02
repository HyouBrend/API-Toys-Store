import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import {
  Container,
  Card,
  Spinner,
  Modal,
  Button,
  FormControl,
} from "react-bootstrap";
import { FaEdit, FaArrowLeft } from "react-icons/fa"; // Import icon edit and back arrow
import "./DetailPage.css";
import { ServiceDetail } from "../../config/service/ServiceDetail/ServiceDetail";
import { Toy } from "../../config/model/ModelToy";
import { ModelDetailDoll } from "../../config/model/ModelDetail/ModelDetailDoll";
import { ModelDetailElectronicToy } from "../../config/model/ModelDetail/ModelDetailElectronicToy";
import { ModelDetailPlasticToy } from "../../config/model/ModelDetail/ModelDetailPlasticToy";

const DetailPage: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate(); // Initialize useNavigate
  const [toy, setToy] = useState<
    | Toy
    | ModelDetailDoll
    | ModelDetailElectronicToy
    | ModelDetailPlasticToy
    | null
  >(null);
  const [error, setError] = useState<string | null>(null);
  const [showModal, setShowModal] = useState(false);
  const [currentEditField, setCurrentEditField] = useState<string | null>(null);
  const [editValue, setEditValue] = useState<string>("");

  useEffect(() => {
    const fetchToyDetail = async () => {
      if (!id) {
        setError("ID is required");
        return;
      }

      const service = new ServiceDetail("http://localhost:8080");
      try {
        const toyData = await service.getToyById(id);
        setToy(toyData);
      } catch (err: any) {
        setError(err.message || "Failed to fetch toy details");
      }
    };

    fetchToyDetail();
  }, [id]);

  const handleIconClick = (field: string, value: string) => {
    setEditValue(value);
    setCurrentEditField(field);
    setShowModal(true);
  };

  const handleSave = async () => {
    if (toy && currentEditField) {
      const updatedToy: Partial<
        Toy | ModelDetailDoll | ModelDetailElectronicToy | ModelDetailPlasticToy
      > = {
        ...toy,
      };

      // Pastikan nama-nama field sesuai dengan backend
      if (currentEditField === "Type") updatedToy.type = editValue;
      else if (currentEditField === "Price")
        updatedToy.price = parseFloat(editValue);
      else if (currentEditField === "Stock")
        updatedToy.stock = parseInt(editValue, 10);
      else if (currentEditField === "Material")
        (updatedToy as ModelDetailDoll).material = editValue;
      else if (currentEditField === "Size")
        (updatedToy as ModelDetailDoll).size = editValue;
      else if (currentEditField === "Battery Type")
        (updatedToy as ModelDetailElectronicToy).battery_type = editValue;
      else if (currentEditField === "Voltage")
        (updatedToy as ModelDetailElectronicToy).voltage = editValue;
      else if (currentEditField === "Plastic Type")
        (updatedToy as ModelDetailPlasticToy).plastic_type = editValue;
      else if (currentEditField === "Is BPA Free")
        (updatedToy as ModelDetailPlasticToy).is_bpa_free =
          editValue.toLowerCase() === "yes";

      try {
        const service = new ServiceDetail("http://localhost:8080");
        await service.updateToy(id!, updatedToy); // Panggilan API untuk memperbarui
        setToy({ ...toy, ...updatedToy } as any); // Update state lokal
      } catch (err: any) {
        setError(err.message || "Failed to update toy details");
      }
    }
    setShowModal(false);
  };

  const renderModal = () => {
    if (!currentEditField) return null;

    const fieldLabels: { [key: string]: string } = {
      Type: "Type",
      Price: "Price",
      Stock: "Stock",
      Material: "Material",
      Size: "Size",
      "Battery Type": "Battery Type",
      Voltage: "Voltage",
      "Plastic Type": "Plastic Type",
      "Is BPA Free": "Is BPA Free",
    };

    const fieldLabel = fieldLabels[currentEditField] || "Unknown";

    return (
      <Modal show={showModal} onHide={() => setShowModal(false)} centered>
        <Modal.Header closeButton>
          <Modal.Title>Edit {fieldLabel}</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <FormControl
            value={editValue}
            onChange={(e) => setEditValue(e.target.value)}
            aria-label={`Edit ${fieldLabel}`}
          />
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={() => setShowModal(false)}>
            Cancel
          </Button>
          <Button variant="primary" onClick={handleSave}>
            Save
          </Button>
        </Modal.Footer>
      </Modal>
    );
  };

  if (error) {
    return (
      <Container className="centered-container">
        <Card className="p-4">
          <p>{error}</p>
        </Card>
      </Container>
    );
  }

  if (!toy) {
    return (
      <Container className="centered-container">
        <Spinner animation="border" />
      </Container>
    );
  }

  return (
    <>
      <Container className="centered-container">
        <Card className="detail-page p-4">
          <Card.Header className="card-header">
            <Button
              variant="link"
              onClick={() => navigate(-1)}
              className="back-button"
            >
              <FaArrowLeft />
            </Button>
            <Card.Title className="card-title">{toy.name}</Card.Title>
          </Card.Header>

          <Card.Body>
            <div className="detail-info">
              <div className="info-row">
                <p>
                  <strong>Type</strong>
                  <span className="colon">:</span> {toy.type}
                </p>
                <FaEdit
                  className="edit-icon"
                  onClick={() => handleIconClick("Type", toy.type)}
                />
              </div>
              <div className="info-row">
                <p>
                  <strong>Price</strong>
                  <span className="colon">:</span> {toy.price}
                </p>
                <FaEdit
                  className="edit-icon"
                  onClick={() => handleIconClick("Price", toy.price.toString())}
                />
              </div>
              <div className="info-row">
                <p>
                  <strong>Stock</strong>
                  <span className="colon">:</span> {toy.stock}
                </p>
                <FaEdit
                  className="edit-icon"
                  onClick={() => handleIconClick("Stock", toy.stock.toString())}
                />
              </div>
              {"material" in toy && (
                <div className="info-row">
                  <p>
                    <strong>Material</strong>
                    <span className="colon">:</span>{" "}
                    {(toy as ModelDetailDoll).material}
                  </p>
                  <FaEdit
                    className="edit-icon"
                    onClick={() =>
                      handleIconClick(
                        "Material",
                        (toy as ModelDetailDoll).material
                      )
                    }
                  />
                </div>
              )}
              {"size" in toy && (
                <div className="info-row">
                  <p>
                    <strong>Size</strong>
                    <span className="colon">:</span>{" "}
                    {(toy as ModelDetailDoll).size}
                  </p>
                  <FaEdit
                    className="edit-icon"
                    onClick={() =>
                      handleIconClick("Size", (toy as ModelDetailDoll).size)
                    }
                  />
                </div>
              )}
              {"battery_type" in toy && (
                <div className="info-row">
                  <p>
                    <strong>Battery Type</strong>
                    <span className="colon">:</span>{" "}
                    {(toy as ModelDetailElectronicToy).battery_type}
                  </p>
                  <FaEdit
                    className="edit-icon"
                    onClick={() =>
                      handleIconClick(
                        "Battery Type",
                        (toy as ModelDetailElectronicToy).battery_type
                      )
                    }
                  />
                </div>
              )}
              {"voltage" in toy && (
                <div className="info-row">
                  <p>
                    <strong>Voltage</strong>
                    <span className="colon">:</span>{" "}
                    {(toy as ModelDetailElectronicToy).voltage}
                  </p>
                  <FaEdit
                    className="edit-icon"
                    onClick={() =>
                      handleIconClick(
                        "Voltage",
                        (toy as ModelDetailElectronicToy).voltage
                      )
                    }
                  />
                </div>
              )}
              {"plastic_type" in toy && (
                <div className="info-row">
                  <p>
                    <strong>Plastic Type</strong>
                    <span className="colon">:</span>{" "}
                    {(toy as ModelDetailPlasticToy).plastic_type}
                  </p>
                  <FaEdit
                    className="edit-icon"
                    onClick={() =>
                      handleIconClick(
                        "Plastic Type",
                        (toy as ModelDetailPlasticToy).plastic_type
                      )
                    }
                  />
                </div>
              )}
              {"is_bpa_free" in toy && (
                <div className="info-row">
                  <p>
                    <strong>Is BPA Free</strong>
                    <span className="colon">:</span>{" "}
                    {(toy as ModelDetailPlasticToy).is_bpa_free ? "Yes" : "No"}
                  </p>
                  <FaEdit
                    className="edit-icon"
                    onClick={() =>
                      handleIconClick(
                        "Is BPA Free",
                        (toy as ModelDetailPlasticToy).is_bpa_free
                          ? "Yes"
                          : "No"
                      )
                    }
                  />
                </div>
              )}
            </div>
          </Card.Body>
        </Card>
      </Container>
      {renderModal()}
    </>
  );
};

export default DetailPage;
