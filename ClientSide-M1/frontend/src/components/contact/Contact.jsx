import React from "react";
import Back from "../common/back/Back";
import "./contact.css";
import { useState } from "react";

const Contact = () => {
  const map = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2934.650554030496!2d21.159046015643476!3d42.66291397916808!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13549ec3d0c9f2ff%3A0xb8428efb6df9469b!2sPrishtina!5e0!3m2!1sen!2s!4v1652535615693!5m2!1sen!2s';

  const [fullName, setFullName] = useState("");
  const [subject, setSubject] = useState("");
  const [emailAddress, setEmailAddress] = useState("");
  const [message, setMessage] = useState("");
  const [feedbackMessage, setFeedbackMessage] = useState("");
  const [isSuccess, setIsSuccess] = useState(false);

  const handleContact = async (event) => {
    event.preventDefault();

    try {
      const response = await fetch("http://localhost:8080/contact", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          fullName,
          subject,
          emailAddress,
          message,
        }),
      });

      if (response.ok) {
        setFeedbackMessage("Message sent successfully.");
        setIsSuccess(true);
        // Optionally, reset form fields after successful submission
        setFullName("");
        setSubject("");
        setEmailAddress("");
        setMessage("");
      } else {
        setFeedbackMessage("Failed to send message.");
        setIsSuccess(false);
      }
    } catch (error) {
      setFeedbackMessage("Error sending message: " + error.message);
      setIsSuccess(false);
    }

    // Clear the feedback message after a few seconds
    setTimeout(() => setFeedbackMessage(""), 5000);
  };

  return (
    <>
      <Back title="Contact us" />
      <section className="contacts padding">
        <div className="container shadow flexSB">
          <div className="left row">
            <iframe src={map} width="600" height="450" style={{ border: 0 }} allowFullScreen="" loading="lazy" referrerPolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <div className="right row">
            <h1>Contact us</h1>
            <p>We're open for any suggestion or just to have a chat</p>

            <div className="items grid2">
              <div className="box">
                <h4>ADDRESS:</h4>
                <p>198 West 21th Street, Suite 721 Prishtine </p>
              </div>
              <div className="box">
                <h4>EMAIL:</h4>
                <p>info@tsk.com</p>
              </div>
              <div className="box">
                <h4>PHONE:</h4>
                <p>+ 383 44 123 123</p>
              </div>
            </div>

            {feedbackMessage && (
              <div className={`feedback-message ${isSuccess ? 'success' : 'error'}`}>
                {feedbackMessage}
              </div>
            )}

            <form onSubmit={handleContact}>
              <div className="flexSB">
                <input
                  type="text"
                  value={fullName}
                  onChange={(e) => setFullName(e.target.value)}
                  placeholder="Name"
                />
                <input
                  type="email"
                  value={emailAddress}
                  onChange={(e) => setEmailAddress(e.target.value)}
                  placeholder="Email"
                />
              </div>
              <input
                type="text"
                value={subject}
                onChange={(e) => setSubject(e.target.value)}
                placeholder="Subject"
              />
              <textarea
                cols="30"
                rows="10"
                value={message}
                onChange={(e) => setMessage(e.target.value)}
                placeholder="Message"
              ></textarea>
              <button type="submit" className="primary-btn">SEND MESSAGE</button>
            </form>

            <h3>Follow us here</h3>
            <span>FACEBOOK TWITTER INSTAGRAM DRIBBBLE</span>
          </div>
        </div>
      </section>
    </>
  );
};

export default Contact;
