import React from "react";
import Sidebar from "./Sidebar";
import LoadingOverlay from "../components/LoadingOverlay";
import Header from "../components/Header";

export default function MainLayout({ children, isLoading = false }) {
  return (
    <div className="flex h-screen overflow-hidden bg-[#191C1E] text-white">
      <Sidebar />

      <main className="flex-1 overflow-y-auto p-10 relative">
        {isLoading && <LoadingOverlay />}
        {children}
      </main>
    </div>
  );
}
